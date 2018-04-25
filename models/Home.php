<?php

namespace zabachok\burivuh\models;

class Home
{
    public $title = 'Root';
    public $category_id = 0;
    public $parent_id = null;
    public $created_at = '2016-01-01 12:00:00';

    public $breadcrumbs = [];

    public function getBreadcrumbs($iterator)
    {
        return [];
    }
}