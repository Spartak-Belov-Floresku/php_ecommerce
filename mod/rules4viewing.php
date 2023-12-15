<?php
require_once('../inc/autoload.php');
Input::putSession("limit", IntegerFilter::filter(Input::get('limit') != ""? Input::get('limit'): Url::limintPerPage()));
Input::putSession("sort",Input::get('sort') != ""?Input::get('sort'):Url::orderBy()[0]);
Input::putSession("by",Input::get('aseDesc') != ""?Input::get('aseDesc'):Url::orderBy()[1]);
?>