<?php

namespace Magecom\Learning\Block;

use Magento\Framework\View\Element\Template;

/**
 *Index & Front controller block
 *
 * @category Magecom
 * @package Magecom\Learning\Block
 * @author  Magecom
 */
class Main extends Template
{
    /**
     * Get header
     */
    public function getHead()
    {
        echo "It's working!";
    }

    /**
     * Render links to others Index & Front controller actions
     *
     * @param $link1
     * @param $link2
     * @param $link3
     */
    public function getLinks($link1, $link2, $link3)
    {
        echo
        "<a href='../$link1'>Go to $link1</a><br>
         <a href='../$link2'>Go to $link2</a><br>
         <a href='../$link3'>Go to $link3</a>";
    }
}