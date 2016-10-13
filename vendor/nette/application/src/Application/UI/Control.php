<?php

/**
 * This file is part of the Nette Framework (https://nette.org)
 * Copyright (c) 2004 David Grudl (https://davidgrudl.com)
 */

namespace Nette\Application\UI;

use Nette;


/**
 * Control is renderable Presenter component.
 *
 * @property-read ITemplate $template
 */
abstract class Control extends PresenterComponent implements IRenderable
{
	/** @var ITemplateFactory */
	private $templateFactory;

	/** @var ITemplate */
	private $template;

	/** @var array */
	private $invalidSnippets = array();

	/** @var bool */
	public $snippetMode;
        
        public $owners = [
            1 => 'Zombie',
            2 => 'Human'
        ];
        
        public $itemTypes = [
            'helmet' => 'Helmet',
            'mask' => 'Mask',
            'cloak' => 'Cloak',
            'necklace' => 'Necklace',
            'armor' => 'Armor',
            'glove' => 'Glove',
            'ring' => 'Ring',
            'belt' => 'Belt',
            'trousers' => 'Trousers',
            'boot' => 'Boots',
            'first_weapon' => 'First weapon',
            'second_wepaon' => 'Second weapon',
            'potion' => 'Potion'
        ];
        
        public $npcTypes = [
            'normal' => 'Normal',
            'boss' => 'Boss'
        ];

	/********************* template factory ****************d*g**/


	public function setTemplateFactory(ITemplateFactory $templateFactory)
	{
		$this->templateFactory = $templateFactory;
	}


	/**
	 * @return ITemplate
	 */
	public function getTemplate()
	{
		if ($this->template === NULL) {
			$value = $this->createTemplate();
			if (!$value instanceof ITemplate && $value !== NULL) {
				$class2 = get_class($value); $class = get_class($this);
				throw new Nette\UnexpectedValueException("Object returned by $class::createTemplate() must be instance of Nette\\Application\\UI\\ITemplate, '$class2' given.");
			}
			$this->template = $value;
		}
		return $this->template;
	}


	/**
	 * @return ITemplate
	 */
	protected function createTemplate()
	{
		$templateFactory = $this->templateFactory ?: $this->getPresenter()->getTemplateFactory();
		return $templateFactory->createTemplate($this);
	}


	/**
	 * Descendant can override this method to customize template compile-time filters.
	 * @param  ITemplate
	 * @return void
	 */
	public function templatePrepareFilters($template)
	{
	}


	/**
	 * Saves the message to template, that can be displayed after redirect.
	 * @param  string
	 * @param  string
	 * @return \stdClass
	 */
	public function flashMessage($message, $type = 'info')
	{
		$id = $this->getParameterId('flash');
		$messages = $this->getPresenter()->getFlashSession()->$id;
		$messages[] = $flash = (object) array(
			'message' => $message,
			'type' => $type,
		);
		$this->getTemplate()->flashes = $messages;
		$this->getPresenter()->getFlashSession()->$id = $messages;
		return $flash;
	}


	/********************* rendering ****************d*g**/


	/**
	 * Forces control or its snippet to repaint.
	 * @return void
	 */
	public function redrawControl($snippet = NULL, $redraw = TRUE)
	{
		if ($redraw) {
			$this->invalidSnippets[$snippet === NULL ? "\0" : $snippet] = TRUE;

		} elseif ($snippet === NULL) {
			$this->invalidSnippets = array();

		} else {
			unset($this->invalidSnippets[$snippet]);
		}
	}


	/** @deprecated */
	function invalidateControl($snippet = NULL)
	{
		$this->redrawControl($snippet);
	}

	/** @deprecated */
	function validateControl($snippet = NULL)
	{
		$this->redrawControl($snippet, FALSE);
	}


	/**
	 * Is required to repaint the control or its snippet?
	 * @param  string  snippet name
	 * @return bool
	 */
	public function isControlInvalid($snippet = NULL)
	{
		if ($snippet === NULL) {
			if (count($this->invalidSnippets) > 0) {
				return TRUE;

			} else {
				$queue = array($this);
				do {
					foreach (array_shift($queue)->getComponents() as $component) {
						if ($component instanceof IRenderable) {
							if ($component->isControlInvalid()) {
								// $this->invalidSnippets['__child'] = TRUE; // as cache
								return TRUE;
							}

						} elseif ($component instanceof Nette\ComponentModel\IContainer) {
							$queue[] = $component;
						}
					}
				} while ($queue);

				return FALSE;
			}

		} else {
			return isset($this->invalidSnippets["\0"]) || isset($this->invalidSnippets[$snippet]);
		}
	}


	/**
	 * Returns snippet HTML ID.
	 * @param  string  snippet name
	 * @return string
	 */
	public function getSnippetId($name = NULL)
	{
		// HTML 4 ID & NAME: [A-Za-z][A-Za-z0-9:_.-]*
		return 'snippet-' . $this->getUniqueId() . '-' . $name;
	}
        
        public function insertUploadedImage($image, $folder, $name)
        {
            $filePath = 'images/';
            $name = $this->deleteUtfCharacters($name);
            $name = strtolower($name);
            $fileName = '/'.$name.'.png';
            $path = $filePath . $folder . $fileName;
            $image->move($path);

            return $path;
        }
        
         public function deleteUtfCharacters($word)
        {
            // i pro multi-byte (napr. UTF-8)
            $table = Array(
              'ä'=>'a',
              'Ä'=>'A',
              'á'=>'a',
              'Á'=>'A',
              'à'=>'a',
              'À'=>'A',
              'ã'=>'a',
              'Ã'=>'A',
              'â'=>'a',
              'Â'=>'A',
              'č'=>'c',
              'Č'=>'C',
              'ć'=>'c',
              'Ć'=>'C',
              'ď'=>'d',
              'Ď'=>'D',
              'ě'=>'e',
              'Ě'=>'E',
              'é'=>'e',
              'É'=>'E',
              'ë'=>'e',
              'Ë'=>'E',
              'è'=>'e',
              'È'=>'E',
              'ê'=>'e',
              'Ê'=>'E',
              'í'=>'i',
              'Í'=>'I',
              'ï'=>'i',
              'Ï'=>'I',
              'ì'=>'i',
              'Ì'=>'I',
              'î'=>'i',
              'Î'=>'I',
              'ľ'=>'l',
              'Ľ'=>'L',
              'ĺ'=>'l',
              'Ĺ'=>'L',
              'ń'=>'n',
              'Ń'=>'N',
              'ň'=>'n',
              'Ň'=>'N',
              'ñ'=>'n',
              'Ñ'=>'N',
              'ó'=>'o',
              'Ó'=>'O',
              'ö'=>'o',
              'Ö'=>'O',
              'ô'=>'o',
              'Ô'=>'O',
              'ò'=>'o',
              'Ò'=>'O',
              'õ'=>'o',
              'Õ'=>'O',
              'ő'=>'o',
              'Ő'=>'O',
              'ř'=>'r',
              'Ř'=>'R',
              'ŕ'=>'r',
              'Ŕ'=>'R',
              'š'=>'s',
              'Š'=>'S',
              'ś'=>'s',
              'Ś'=>'S',
              'ť'=>'t',
              'Ť'=>'T',
              'ú'=>'u',
              'Ú'=>'U',
              'ů'=>'u',
              'Ů'=>'U',
              'ü'=>'u',
              'Ü'=>'U',
              'ù'=>'u',
              'Ù'=>'U',
              'ũ'=>'u',
              'Ũ'=>'U',
              'û'=>'u',
              'Û'=>'U',
              'ý'=>'y',
              'Ý'=>'Y',
              'ž'=>'z',
              'Ž'=>'Z',
              'ź'=>'z',
              'Ź'=>'Z',
              '\''=>'',
              ' '=>'_'
            );

            $text = strtr($word, $table);
            return $text;
        }

}
