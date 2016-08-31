<?php

namespace Mkkp\Enemy;

use Imagine\Gd\Font;
use Imagine\Image\Color;
use Imagine\Image\ImageInterface;
use Imagine\Image\Point;

class Billboard
{
	/**
	 * @var ImageInterface
	 */
	private $image;

	/**
	 * @var string
	 */
	private $font;

	public function __construct($image, $font)
	{
		$this->image = $image;
		$this->font = $font;
	}

	public static function createFromBaseImage($baseImagePath, $font)
	{
		return new Billboard(
			(new \Imagine\Gd\Imagine())->open($baseImagePath),
			$font
		);
	}

	public function drawText($text, $color, $centerOffset)
	{
		$fontSize = 36;
		do {
			$font = new Font(
					$this->font,
					$fontSize,
					new Color($color)
			);
			$textBox = $font->box($text);
			$fontSize--;
		} while($fontSize > 8 && $this->image->getSize()->getWidth() * 0.95 < $textBox->getWidth());

		$textPosition = new Point(
			round(($this->image->getSize()->getWidth() - $textBox->getWidth()) / 2),
			round(($this->image->getSize()->getHeight() / 2) + $centerOffset)
		);

		$this->image->draw()
			->text($text, $font, $textPosition);

		return $this;
	}

	public function show()
	{
		$this->image->show('png');
		return $this;
	}

	public function save($file)
	{
		$this->image->save($file);
		return $this;
	}
}
