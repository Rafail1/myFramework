<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Logic\Helper;

/**
 * Description of Pager
 *
 * @author raf
 */
class Pager {

    private $onPageCnt;
    private $pageCount;
    private $page;

    public function __construct($arr) {
        $p = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT);
        $onPageCount = filter_input(INPUT_GET, 'limit');
        if ($onPageCount == 'all') {
            $onPageCount = count($arr);
        } elseif (!$onPageCount) {
            $onPageCount = 100;
        } else {
            $onPageCount = intval($onPageCount);
        }
        if ($p <= 0) {
            $p = 1;
        }
        $this->page = $p;
        $this->onPageCnt = $onPageCount;
        $this->arr = $arr;
    }

    function getPageLimit() {
        return $this->onPageCnt;
    }

    function getPage() {
        return $this->page;
    }

    function getPageArr() {
        if ($this->page > $this->getPageCount()) {
            return [];
        }
        $from = $this->onPageCnt * ($this->page - 1);
        return array_slice($this->arr, $from, $this->onPageCnt, true);
    }

    function getPageCount() {
        $this->pageCount = ceil(count($this->arr) / $this->onPageCnt);
        return $this->pageCount;
    }

    function getPageString() {
        if (filter_input(INPUT_SERVER, 'QUERY_STRING')) {
            $escape = ['page', 'limit'];
            foreach ($escape as $k) {
                if ($_GET[$k]) {
                    unset($_GET[$k]);
                }
            }
            $query = implode('&', $_GET);
            if($query) {
                $qs = "&".$query;
            }
        }
        $response = '<ul class="pagination">';
        for ($i = 0; $i < $this->getPageCount(); $i++) {
            $page = $i + 1;
            $response .= '<li';
            if ($page == $this->page) {
                $response .= ' class="active"';
            }
            $response .= '>';
            $response .= '<a href="?page=' . $page . '&limit=' . $this->getPageLimit() . $qs . '">' . $page . '</a>';
            $response .= '</li>';
        }
        $response .= '</ul>';
        return $response;
    }

}
