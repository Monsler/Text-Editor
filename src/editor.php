<?php
use php\gui\UXForm;
use php\gui\UXApplication;
use php\gui\UXLoader;
use php\io\Stream;
use php\gui\UXDialog;
use php\gui\UXImage;
use php\gui\event\UXMouseEvent;
use php\gui\framework\app;
global $editor, $form, $proj;

$editor = new UXForm();
$editor->title = "Text Editor - ".$form->lst1->selectedItem;
$editor->show();
$editor->layout = ((new UXLoader)->load(Stream::of("res://forms/Editor.fxml")));
$editor->addStylesheet("./themes/dark.css");
$editor->textor->style = '-fx-text-fill: #000000';
$editor->textor->text = $proj[$form->lst1->selectedIndex.'p']['content'];
$editor->centerOnScreen();
$editor->icons->add(new UXImage("res://img/icon.png"));

$editor->closebtn->on("action", function(){
    global $editor, $form;
    $editor->hide(); $form->show();
});

$editor->clearbtn->on("action", function(){
    global $editor;
    $editor->textor->text = '';
});

$editor->savebtn->on("action", function(){
    global $form, $proj, $editor;
    $proj[$form->lst1->selectedIndex.'p']['content'] = $editor->textor->text;
    file_put_contents("config.json", json_encode($proj));
    $form->lst1->items->clear();
    $proj = json_decode(file_get_contents("config.json"), true);
    for($i = 0; $i < sizeof($proj); $i++){
        global $form, $proj;
        $form->lst1->items->add($proj[$i.'p']['title']);
    }
});