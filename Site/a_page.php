<?php
include_once "a_content.php";
class a_page
{
    private $the_page;

    public function __construct(a_content $the_page){
        $this->the_page = $the_page;
    }

    private function  show_head()
    {
        if(isset($_POST['actionButton']))
            $_SESSION['logged_in'] = false;

        ?>
        <header>
            <div class="container" id="logo">
                <a href="index.php" title="Логотип">
                    <img src="icon/tawer.png" alt="Логотип">
                </a>
            </div>
            <div class="container" id="navii">
                <nav class="navi">
                    <? $this->show_menu()?>
                </nav>
            </div>
            <div class="container">
                <form action="index.php" method="post">

                    <?
                    if($_SESSION['logged_in']) {
                        print("<input  class='registerbtn' name='actionButton' type='submit' value='Выйти'>");
                        $format = '<lable>%s</lable>';
                        print sprintf($format,$_SESSION['login']);
                    }
                    ?>
                </form>
            </div>
        </header>
        <?php
    }

    private function start_page(){
        ?>
        <html lang="ru">
        <head>
            <title>
                <?php
                print $this->the_page->get_title();
                ?>
            </title>
            <link rel="stylesheet" href="main.css">
        </head>
        <body>
        <?php
        $this->show_head();
    }

    private function show_title(){
        ?>

        <?php
    }

    private function show_menu(){
        ?>
        <div class="menu">
            <?php
            $m = json_parser::get_full_info("menu.json");
            foreach ($m as $page_info){
                if (
                    ("/Site/".$page_info['addr'] === $_SERVER['PHP_SELF'] ||
                    ($page_info['addr'] === 'index.php' && $_SERVER['PHP_SELF'] === '/'))
                )
                {
                    if($page_info['hidden'] = 1){
                        print ("<a class='logotext'>{$page_info['name']}</a>");
                    }
                    if (($page_info['hidden'] == 0) && $_SESSION['logged_in']){
                        print ("<a class='logotext'>{$page_info['name']}</a>");
                    }
                } else {
                    if(($page_info['hidden'] == 1) && !$_SESSION['logged_in'] || $page_info['addr'] === 'index.php'){
                        print ("<a class='logotext' href='{$page_info['addr']}'>{$page_info['name']}</a>");
                    }
                    if (($page_info['hidden'] == 0) && $_SESSION['logged_in']){
                        print ("<a class='logotext' href='{$page_info['addr']}'>{$page_info['name']}</a>");
                    }
                }
            }
            ?>
        </div>
        <?php
    }

    private function show_content(){
        $this->the_page->show_content();
    }

    private function show_footer(){
        ?>
        <footer>
            <h3 class="footer">
                © Cheshikhin Maksim, 2021
            </h3>
        </footer>
        <?php
    }

    private function finish_page(){
        ?>
        </body></html>
        <?php
    }

    public function create(){
        $this->start_page();
        $this->show_title();
        $this->show_content();
        $this->show_footer();
        $this->finish_page();
    }


}