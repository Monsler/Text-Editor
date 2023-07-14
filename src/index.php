<?php 
use php\gui\UXForm;
use php\gui\UXApplication;
use php\gui\UXLoader;
use php\io\Stream;
use php\gui\UXDialog;
use php\gui\UXImage;
use php\gui\event\UXMouseEvent;
use php\gui\framework\app;
UXApplication::launch(function(){
    global $form; 
    $form = new UXForm();
    loadMenu();
    # $t = array();
    #$t[1] = array();
  #  $t[1]['title'] = 'Text Editor Welcome Note';
    #$t[1]['content'] = 'Welcome! We hope you will like our application! <3';
   # file_put_contents("config.json", json_encode($t));
});

public function loadMenu(){
    global $form;
    $t = array();
    $form->size = [500, 400];
    $form->title = "Text Editor: Projects";
    $form->minWidth = 400;
    $form->minHeight = 350;
    $form->icons->add(new UXImage("res://img/icon.png"));
    $form->layout = ((new UXLoader())->load(Stream::of("res://forms/MainForm.fxml")));
     $form->show();
    $form->addStylesheet('/themes/dark.css');
    $form->centerOnScreen();

    $form->btn1->on("action", function(){
        $name = UXDialog::input("Project name:");
        if($name !== ""){
            global $form, $proj;
            $form->lst1->items->add($name);
            $s = -1 + sizeof($proj) + 1;
            $proj[$s.'p'] = array();
            $proj[$s.'p']['title'] = $name;
            $proj[$s.'p']['content'] = '';
            file_put_contents("config.json", json_encode($proj));
        }
    });

    global $proj;
    $proj = json_decode(file_get_contents("config.json"), true);
    for($i = 0; $i < sizeof($proj); $i++){
        global $form, $proj;
        $form->lst1->items->add($proj[$i.'p']['title']);
    }

    $form->btn3->on("action", function() {
       global $form;
       if($form->lst1->selectedIndex != -1){
        
        $form->hide();
        require 'res://editor.php'; 
       }else{
        UXDialog::show("Select one of the projects, please.", 'WARNING');
       }
    });

    $form->btn2->on("action", function(){
        global $form, $proj;
        unset($proj[$form->lst1->selectedIndex.'p']);
        $form->lst1->items->removeByIndex($form->lst1->selectedIndex);
        file_put_contents("config.json", json_encode($proj));
    });
}
