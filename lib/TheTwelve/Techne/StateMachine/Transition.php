<?php

namespace TheTwelve\Techne\StateMachine;

class Transition implements \TheTwelve\Techne\Transition
{

	/**
	 * the initial state, before the transition
	 * @var TheTwelve\Techne\State
	 */
	protected $initialState;

	/**
     * the state after the transition
     * @var TheTwelve\Techne\State
	 */
	protected $transitionedState;

	/**
	 * a lambda function that should return a boolean value
	 * will be attempted before processing a transition
	 * @var \Closure
	 */
	protected $beforeTransition;

	/**
	 * a lambda function that is run after a transition is
	 * processed
	 * @var \Closure
	 */
	protected $afterTransition;

	/**
	 * 
	 * @var 
	 */
	protected $transitionState;

	/**
	 * initialize the transition
	 * @param TheTwelve\Techne\State|array $from
	 * @param TheTwelve\Techne\State $to
	 */
	public function __construct($from, $to)
	{

		$this->initialState = $from;
		$this->transitionedState = $to;

	}

	/**
	 * @return string
	 */
	public function __toString()
	{

		if (is_array($this->initialState)) {
			return '[' . join(', ', $this->initialState) . '] -> ' . $this->transitionState;
		}

		return $this->initialState . ' -> ' . $this->transitionedState;

	}

	/**
	 * returns true if the supplied state matches the initial state
	 * of this transition
	 * @param \TheTwelve\Techne\State $state
	 * @return boolean
	 */
	public function initialStateIs($state)
	{

		if (is_array($this->initialState)) {
			return in_array($state, $this->initialState);
		}

		return $this->initialState == $state;

	}

	/**
	 * process the transition. returns the state after the transition has been
	 * performed
	 * @return \TheTwelve\Techne\State
	 */
	public function process()
	{

		if ($this->beforeTransition && !$this->beforeTransition()) {
			return false;
		}

		if ($this->afterTransition) {
			$this->afterTransition();
		}

		return $this->transitionedState;

	}

	/**
	 * a guard check to be attempted before processing a transition
	 * @param \Closure $function
	 * @return \TheTwelve\Techne\Transition
	 */
	public function before(\Closure $function)
	{

		$this->beforeTransition = $function;
		return $this;

	}

	/**
	 * a function run after the transition has been processed
	 * @param \Closure $function
	 * @return \TheTwelve\Techne\Transition
	 */
	public function after(\Closure $function)
	{

		$this->afterTransition = $function;
		return $this;

	}

	/**
	 * a work-around for calling the before and after transition closures
	 * @param string $method
	 * @param array $args
	 * @throws \BadMethodCallException
	 */
	public function __call($method, $args)
	{

		if ($this->{$method} instanceof \Closure) {
			return call_user_func_array($this->{$method}, $args);
    	}

		throw new \BadMethodCallException('Method [' . $method . '] does not exist');

    }

}
