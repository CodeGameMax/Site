<?php
include_once "a_content.php";
include_once "a_page.php";
include_once "json_parser.php";

class third extends a_content {

    public function __construct()
    {
        parent::__construct();
        $m = json_parser::get_full_info("menu.json");
        foreach ($m as $page_info) {
            if (!$_SESSION['logged_in'])
            {
                header("Location: index.php");
            }
        }
    }

    private function primeCheck($number){
        if (abs($number) == 1 || $number == 0){
            return 0;
        }
        for ($i = 2; $i<=abs($number)/2;$i++){
            if(abs($number) % $i == 0){
                return 0;
            }
        }
        return 1;
    }

    public  function  show_content()
    {
        ?>
        <div class="content">
            <div class="main">
                <form  action="third.php" method="post">
                    <input name="num1" type="number" >
                    <input name="num2" type="number" >
                    <input class="registerbtn" name="submit" type="submit" value="Посмотреть">
                </form>
            </div>
            <div class="tablelist">
                <table border="1">
                    <tr>
                        <?php
                        if(isset($_POST['submit']))
                        {
                            $number = [];
                            $number[0] = $_POST['num1'];
                            $number[1] = $_POST['num2'];
                            foreach ($_REQUEST as $key=>$req)
                                $number[$key] = $req;
                            for ($i = $number[0];$i<=$number[1];$i++){
                                if($this->primeCheck($i)){
                                    $format = '<td>%d</td>';
                                    print sprintf($format,$i);
                                }
                            }
                        }
                        ?>
                    </tr>
                </table>
            </div>
        </div>
        <?php
    }
}

$p = new a_page(new third());
$p->create();
?>
