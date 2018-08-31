<?php

namespace Boilerplate\Helpers;

	class Slugify{

		public static function getSlug($text = ''){

			$text = strtolower($text);
			$text = preg_replace('/\+/', '', $text);
			$text = preg_replace('/\s+/', '-', $text);
			$text = preg_replace('/[^\w\-]+/', '', $text);
			$text = preg_replace('/\-\-+/', '-', $text);
			$text = preg_replace('/^-+/', '', $text);
			$text = preg_replace('/-+$/', '', $text);
			
			return $text;

		}

	}