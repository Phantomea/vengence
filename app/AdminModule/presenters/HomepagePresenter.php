<?php

namespace AdminModule;


final class HomepagePresenter extends BasePresenter
{
	public function renderDefault()
	{
            $this->redirect("User:default");
	}
}
