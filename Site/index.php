<?php
include_once "a_content.php";
include_once "a_page.php";
include_once "json_parser.php";

class index extends a_content {

    public function show_content()
    {
        ?>
         <div class="content">
             <div class="chill">
                 <p>Это учебный проект который создан для того, чтобы потренироваться создавать сайты PHP</p>
                 <p>В этом семестре я научились работать с такими вещами как:</p>
                 <ul>
                     <li>WinForms на С#</li>
                     <li>Многопоточность</li>
                     <li>Паттер Producer-Consumer</li>
                     <li>Работа с БД, а конкретно MYsql</li>
                     <li>Создание сайтов на языке PHP</li>
                 </ul>
                 <img class="images1" src="tenor.gif">
             </div>
         </div>
        <?php
    }
}

$p = new a_page(new index());
$p->create();
?>