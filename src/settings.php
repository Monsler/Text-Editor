<?php
use php\gui\UXForm;
use php\gui\UXApplication;
use php\gui\UXLoader;
use php\io\Stream;
use php\gui\UXDialog;
use php\gui\UXImage;
use php\gui\event\UXMouseEvent;
use php\gui\framework\app;

global $sets;
$sets = new UXForm();
$sets->show();
#$sets->size = [500, 400];
$sets->title = "Settings";
$sets->icons->add(new UXImage("res://img/icon.png"));
$sets->addStylesheet('./themes/dark.css');
$sets->layout = (new UXLoader()->load(Stream::of("res://forms/Settings.fxml")));
$sets->size = [499, 192];
$sets->resizable = false;
$sets->themelist->items->addAll(["Light", "Dark", "Red"]);
$sets->btn2->on("action", function(){
    global $sets, $form;
    $sets->hide();
    $form->show();
});

$sets->btn1->on("action", function(){
    global $sets, $form;

    if($sets->themelist->selectedIndex == 0){
        file_put_contents("config.json", "[{\"theme\":\"light\"}]");
    }elseif($sets->themelist->selectedIndex == 1){
        file_put_contents("config.json", "[{\"theme\":\"dark\"}]");
    }elseif(file_put_contents("config.json", "[{\"theme\":\"red\"}]");){
        file_put_contents("config.json", "[{\"theme\":\"red\"}]");
    }

    $sets->hide();
    $form->show();
    if(json_decode(file_get_contents("config.json"))['theme'] == "dark"){
        $form->addStylesheet('./themes/dark.css');
    }elseif(json_decode(file_get_contents("config.json"))['theme'] == "light"){
        $form->addStylesheet('./themes/base.css');
    }elseif(json_decode(file_get_contents("config.json"))['theme'] == "red"){
        $form->addStylesheet('./themes/red.css');
    }
});