<?php
/*
Plugin Name: hometitle
Description: Плагин меняет title на главной странице
Version: 1.0
Author: Larisa Kirko
License: GPL2

Copyright YEAR  PLUGIN_AUTHOR_NAME  (email : lorakirko@gmail.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
/*Просто активируйте плагин, в разделе Настройки->Общие заполните поле "Введите title для главной страницы'.
Наслаждайтесь результатом!*/

/*добавляю в админку поле*/
function lk_title()
{
    add_settings_field(// создаем текстовое поле в админке;
        'name',//идентификатор создаваемой настройки-имя поля;
        'Введите title для главной страницы',
        'callback_lk_title',//название поля, которое мы будем видеть в админке wordpress.
        'general'// в каком разделе размещать наше поле.
    );

    register_setting(
        'general',//название группы, к которой будет принадлежать опция.(совпадать с названием группы в функции settings_field ())
        'our_title' //  название опции, которое будет сохраняться в базе данных.
    );//регистрирует новую настройку и функцию обратного вызова, которая нужна для обработки данных, которые будут поступать в базу данных.

}

//вызовем экшен и свяжем с помощью него нашу функцию my_title и хук admin_init. Данный хук позволяет загрузить нашу опцию еще до загрузки самой админки.
add_action('admin_init', 'lk_title');
//В callback-функции пропишем вывод самого текстового поля, которое мы хотим получить.
function callback_lk_title()
{
    echo "<input class='regular-text' type='text' name='our_title' value='" . esc_attr(get_option('our_title')) . "'>";
    //чтобы вывести эти данные из базы данных используем функцию get_option (),
    // в параметре которой пропишем название нашей опции, которая записалась в базу данных.
    //Обернем функцию get_option ('our_adress') в функцию esc_attr () для того,
    // чтобы в нашем поле отображались символы, которые используются в HTML.
}


//хук wp_head, к которому мы прицепим собственную функцию.
add_action('wp_head', 'lk_function_for_title');
//удалила старый <title> с содержимым
remove_action('wp_head', '_wp_render_title_tag', 1);
// функция вывода нужного title на главной странице
function lk_function_for_title()
{
    if (is_front_page()) {
        $title['title'] = get_option('our_title');
        echo '<title>' . $title['title'] . '</title>';
    }
}

