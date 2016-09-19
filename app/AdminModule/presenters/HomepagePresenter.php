<?php

namespace AdminModule;


final class HomepagePresenter extends BasePresenter
{
	public function renderDefault()
	{
            if($this->user->isAllowed())
            {
                $this->redirect("User:default");
            } else {
                $this->redirect("Article:default");
            }
	}
}
