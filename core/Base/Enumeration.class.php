<?php
/***************************************************************************
 *   Copyright (C) 2004-2006 by Konstantin V. Arkhipov                     *
 *                                                                         *
 *   This program is free software; you can redistribute it and/or modify  *
 *   it under the terms of the GNU General Public License as published by  *
 *   the Free Software Foundation; either version 2 of the License, or     *
 *   (at your option) any later version.                                   *
 *                                                                         *
 ***************************************************************************/
/* $Id$ */

	/**
	 * Parent of all enumeration classes.
	 * 
	 * @see AccessMode for example
	 * 
	 * @ingroup Base
	 * @ingroup Module
	**/
	abstract class Enumeration extends NamedObject implements Serializable
	{
		protected $names = array(/* override me */);
		
		public function __construct($id)
		{
			$this->changeId($id);
		}
		
		/// @{ prevent's serialization of names' array
		// TODO: sync with module's Enumeration
		public function __sleep()
		{
			return array('id');
		}
		
		public function __wakeup()
		{
			$this->changeId($this->id);
		}
		
		public function serialize()
		{
			return (string) $this->id;
		}
		
		public function unserialize($serialized)
		{
			$this->changeId($serialized);
		}
		/// @}
		
		public static function getList(Enumeration $enum)
		{
			return $enum->getObjectList();
		}
		
		/**
		 * must return any existent ID
		 * 1 should be ok for most enumerations
		**/
		public static function getAnyId()
		{
			return 1;
		}
		
		public function getObjectList()
		{
			$list = array();
			$names = $this->getNameList();
			
			foreach (array_keys($names) as $id)
				$list[] = new $this($id);

			return $list;
		}

		public function toString()
		{
			return $this->name;
		}
		
		public function getNameList()
		{
			return $this->names;
		}
		
		protected function changeId($id)
		{
			$names = $this->getNameList();

			if (isset($names[$id])) {
				$this->id = $id;
				$this->name = $names[$id];
			} else
				throw new MissingElementException(
					"knows nothing about such id == {$id}"
				);
			
			return $this;
		}
	}
?>