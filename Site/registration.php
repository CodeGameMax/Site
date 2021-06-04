<?php
include_once "a_content.php";
include_once "a_page.php";
include_once "json_parser.php";

class registrator{

    public $user_data;

    public function __construct($data)
    {
        $this->user_data = $data;
    }

    public function is_data_sent(): bool{
        return isset($this->user_data['login'])
            && isset($this->user_data['password'])
            && isset($this->user_data['password2']);

    }

    public function save_data(){
        $filename = "users.dat";
        if(is_writable($filename) || !file_exists($filename)){
            $psw = password_hash($this->user_data['password'],PASSWORD_DEFAULT);
            $f = fopen($filename, "a");
            if($f!=null){
                fwrite($f,$this->user_data['login']. " ");
                fwrite($f,$psw. " ");
                fwrite($f,$this->user_data['firstname']. " ");
                fwrite($f,$this->user_data['lastname']. " ");
                fwrite($f,$this->user_data['middlename']. " ");
                fwrite($f,$this->user_data['email']."\r\n");
                fclose($f);
            }
        }

    }

    public function is_login_correct($login) :bool{
        $filename = "users.dat";
        $res = true;
        if(is_readable($filename))
        {
            $f = fopen($filename,"r");
            while($s = fgets($f))
            {
                $sa = explode(" ",$s);
                if(strcmp($sa[0],$login)===0)
                {
                    $res = false;
                }
            }
            fclose($f);
        }

        return $res;
    }

    public function is_passwords_correct(){
        return $this->is_data_sent()
            && strlen($this->user_data['password']) >=6
            && $this->user_data['password'] === $this->user_data['password2'];
    }
}

class registration extends a_content {

    private $reg;

    public function __construct()
    {
        parent::__construct();
        $this->reg = new registrator($this->request);
    }

    public function show_content()
    {
        if ($this->reg->is_data_sent()){
            if (!$this->reg->is_passwords_correct()){
                print ("<div class='err_msg'>Проверьте ввод паролей.</div>");
            }
            elseif (!$this->reg->is_login_correct($this->reg->user_data['login'])){
                print ("<div class='err_msg'>Такой логин уже используется.</div>");
            }
            else{
                $this->reg->save_data();
            }
        }

        ?>
        <div class="content">
                <div class="reg">
                    <form action="registration.php" method="post">

                        <label><b>Логин:</b></label>
                        <input type="text" name="login">

                        <label for="psw"><b>Пароль:</b></label>
                        <input type="password" name="password">

                        <label for="psw"><b>Повтор пароля:</b></label>
                        <input type="password" name="password2">

                        <label><b>Имя:</b></label>
                        <input type="text" name="firstname">

                        <label><b>Фамилия:</b></label>
                        <input type="text" name="lastname">

                        <label><b>Отчество:</b></label>
                        <input type="text" name="middlename">

                        <label><b>Почта:</b></label>
                        <input type="email" name="email">

                        <input  class="registerbtn" type="submit" value="Отправить">
                    </form>
                </div>
        </div>
        <?php
    }
}

$p = new a_page(new registration());
$p->create();
?>