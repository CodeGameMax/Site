<?php
include_once "a_content.php";
include_once "a_page.php";
include_once "json_parser.php";

class auntificator
{

    public $user_data;

    public function __construct($data)
    {
        $this->user_data = $data;
    }

    public function is_data_sent(): bool{
        return isset($this->user_data['login1'])
            && isset($this->user_data['password1']);

    }

    public function auntificat($login,$password): bool
    {
        $filename = "users.dat";
        $res = false;
        if(is_readable($filename))
        {
            $f = fopen($filename,"r");
            while($s = fgets($f))
            {
                $sa = explode(" ",$s);
                if(strcmp($sa[0],$login)===0)
                {
                    $res = password_verify($password,$sa[1]);
                }
            }
            fclose($f);
        }

        return $res;
    }

}


class auntification extends a_content {

    private $auf;

    public function __construct()
    {
        parent::__construct();
        $this->auf = new auntificator($this->request);
        if (isset($_POST['submitButton'])){
            if ($this->auf->is_data_sent()) {
                if ($this->auf->auntificat($this->auf->user_data['login1'],
                    $this->auf->user_data['password1'])) {
                    $_SESSION["logged_in"] = "true";
                    $_SESSION["login"] = $this->auf->user_data['login1'];
                    header("Location: index.php");
                }
                else{
                    print ("<div class='err_msg'>Неверный логин или пароль</div>");
                }
            }
        }
    }

    public function show_content()
    {
        ?>
        <div class="content">
            <div class="reg">
                <form method="post">

                    <label><b>Логин:</b></label>
                    <input type="text" name="login1">

                    <label for="psw"><b>Пароль:</b></label>
                    <input type="password" name="password1">


                   <input  name="submitButton" class="registerbtn" type="submit" value="Отправить" onclick="location.href='index.php'"/>
                </form>
            </div>
        </div>
        <?php
    }
}

$p = new a_page(new auntification());
$p->create();
?>