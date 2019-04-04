<?php

namespace App;

use Illuminate\Pagination\BootstrapThreePresenter;

class SmallPaginationPresenter extends BootstrapThreePresenter {

    public function render()
    {
        if ($this->hasPages())
        {
            return sprintf(
                '<ul class="pagination">%s %s %s</ul>',
                $this->getPreviousButton(),
                $this->getLinks(),
                $this->getNextButton()
            );
        }

        return '';
    }

    
}