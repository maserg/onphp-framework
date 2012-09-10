<?php
/***************************************************************************
 *   Copyright (C) 2012 by Evgeniya Tekalin                                *
 *                                                                         *
 *   This program is free software; you can redistribute it and/or modify  *
 *   it under the terms of the GNU Lesser General Public License as        *
 *   published by the Free Software Foundation; either version 3 of the    *
 *   License, or (at your option) any later version.                       *
 *                                                                         *
 ***************************************************************************/

	/**
	 * Base class modelling an AMQ channel
	**/
	class AMQPProxyChannel implements AMQPChannelInterface
	{
		/**
		 * @var AMQPChannelInterface
		 */
		protected $channel = null;

		public function __construct(AMQPChannelInterface $channel)
		{
			$this->channel = $channel;
		}

		/**
		 * @return true
		**/
		public function isOpen()
		{
			return $this->channel->isOpen();
		}

		/**
		 * @return AMQPChannelInterface
		**/
		public function open()
		{
			return $this->channel->open();
		}

		/**
		 * @return AMQPChannelInterface
		**/
		public function close()
		{
			return $this->channel->close();
		}

		/**
		 * @return AMQPChannelInterface
		**/
		public function exchangeDeclare($name, AMQPExchangeConfig $conf)
		{
			try {
				return $this->channel->exchangeDeclare($name, $conf);
			} catch (AMQPServerException $e) {
				return $this->
					transportReconnect()->
					exchangeDeclare($name, $conf);
			}
		}

		/**
		 * @return AMQPChannelInterface
		**/
		public function exchangeDelete($name, $ifUnused = false)
		{
			try {
				return $this->channel->exchangeDelete($name, $ifUnused);
			} catch (AMQPServerException $e) {
				return $this->
					transportReconnect()->
					exchangeDelete($name, $ifUnused);
			}
		}

		public function exchangeBind($destinationName, $sourceName, $routingKey)
		{
			try {
				return $this->channel->exchangeBind(
					$destinationName,
					$sourceName,
					$routingKey
				);
			} catch (AMQPServerException $e) {
				return $this->
					transportReconnect()->
					exchangeBind(
						$destinationName,
						$sourceName,
						$routingKey
					);
			}
		}

		/**
		 * @return AMQPChannelInterface
		**/
		public function exchangeUnbind($destinationName, $sourceName, $routingKey)
		{
			try {
				return $this->channel->exchangeUnbind(
					$destinationName,
					$sourceName,
					$routingKey
				);
			} catch (AMQPServerException $e) {
				return $this->
					transportReconnect()->
					exchangeUnbind(
						$destinationName,
						$sourceName,
						$routingKey
					);
			}
		}

		/**
		 * @return int
		**/
		public function queueDeclare($name, AMQPQueueConfig $conf)
		{
			try {
				return $this->channel->queueDeclare($name, $conf);
			} catch (AMQPServerException $e) {
				return $this->
					transportReconnect()->
					queueDeclare($name, $conf);
			}
		}

		/**
		 * @return AMQPChannelInterface
		**/
		public function queueBind($name, $exchange, $routingKey)
		{
			try {
				return $this->channel->queueBind(
					$name,
					$exchange,
					$routingKey
				);
			} catch (AMQPServerException $e) {
				return $this->
					transportReconnect()->
					queueBind(
						$name,
						$exchange,
						$routingKey
					);
			}
		}

		/**
		 * @return AMQPChannelInterface
		**/
		public function queueUnbind($name, $exchange, $routingKey)
		{
			try {
				return $this->channel->queueUnbind(
					$name,
					$exchange,
					$routingKey
				);
			} catch (AMQPServerException $e) {
				return $this->
					transportReconnect()->
					queueUnbind(
						$name,
						$exchange,
						$routingKey
					);
			}
		}

		/**
		 * @return AMQPChannelInterface
		**/
		public function queuePurge($name)
		{
			try {
				return $this->channel->queuePurge($name);
			} catch (AMQPServerException $e) {
				return $this->
					transportReconnect()->
					queuePurge($name);
			}
		}

		/**
		 * @return AMQPChannelInterface
		**/
		public function queueDelete($name)
		{
			try {
				return $this->channel->queueDelete($name);
			} catch (AMQPServerException $e) {
				return $this->
					transportReconnect()->
					queueDelete($name);
			}
		}

		/**
		 * @return AMQPChannelInterface
		**/
		public function basicPublish($exchange, $routingKey, AMQPOutgoingMessage $msg)
		{
			try {
				return $this->channel->basicPublish(
					$exchange,
					$routingKey,
					$msg
				);
			} catch (AMQPServerException $e) {
				return $this->
					transportReconnect()->
					basicPublish($exchange, $routingKey, $msg);
			}
		}

		/**
		 * @return AMQPChannelInterface
		**/
		public function basicQos($prefetchSize, $prefetchCount)
		{
			try {
			return $this->channel->basicQos($prefetchSize, $prefetchCount);
			} catch (AMQPServerException $e) {
				return $this->
					transportReconnect()->
					basicQos($prefetchSize, $prefetchCount);
			}
		}

		/**
		 * @return AMQPIncomingMessage
		**/
		public function basicGet($queue, $autoAck = true)
		{
			try {
				return $this->channel->basicGet($queue, $autoAck);
			} catch (AMQPServerException $e) {
				return $this->
					transportReconnect()->
					basicGet($queue, $autoAck);
			}
		}


		/**
		 * @return AMQPChannelInterface
		**/
		public function basicAck($deliveryTag, $multiple = false)
		{
			try {
				return $this->channel->basicAck($deliveryTag, $multiple);
			} catch (AMQPServerException $e) {
				return $this->
					transportReconnect()->
					basicAck($deliveryTag, $multiple);
			}
		}

		/**
		 * @return AMQPChannelInterface
		**/
		public function basicConsume($queue, $autoAck, AMQPConsumer $callback)
		{
			try {
				return $this->channel->basicConsume($queue, $autoAck, $callback);
			} catch (AMQPServerException $e) {
				return $this->
					transportReconnect()->
					basicConsume($queue, $autoAck, $callback);
			}
		}

		/**
		 * @return AMQPChannelInterface
		**/
		public function basicCancel($consumerTag)
		{
			try {
				return $this->channel->basicCancel($consumerTag);
			} catch (AMQPServerException $e) {
				return $this->
					transportReconnect()->
					basicCancel($consumerTag);
			}
		}

		/**
		 * @throws AMQPServerException
		 * @return AMQPProxyChannel
		 */
		protected function transportReconnect()
		{
			$this->markAlive(false);

			$this->reconnect();

			return $this;
		}

		private function markAlive($alive = false)
		{
			try {
				$this->channel->getTransport()->
					setAlive($alive);
			} catch (WrongArgumentException $e) {/*no_connection*/}

			return $this;
		}

		/**
		 * @return AMQPProxyChannel
		 * @throws AMQPServerException
		 */
		private function reconnect()
		{
			try {
				$this->channel->getTransport()->
					setCurrent(
						$this->channel->getTransport()->getAlive()
					);
			} catch (WrongArgumentException $e) {
				throw new AMQPServerException($e->getMessage());
			}

			return $this;
		}
	}
?>