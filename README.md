# Finite-State Machine Library
================================

A simple PHP implementation of a [Finite-State Machine](http://en.wikipedia.org/wiki/Finite-state_machine)

## Installation
--------------

Use [Composer](http://getcomposer.org) to install this library in your project 

### Create your composer.json file

      {
          "require": {
              "thetwelvelabs/techne": "dev-master"
          },
          "minimum-stability": "dev"
      }

### Download composer into your application root

      $ curl -s http://getcomposer.org/installer | php

### Install your dependencies

      $ php composer.phar install

## Usage
---------

### Define your FSM

Let's use a light switch as a simple example.  
A light switch as two states: on and off. The state of a light switch is 
transitioned from one to the other by flipping the switch. We'll assume
that the initial state of the light switch is 'off' 

      $machine = new StateMachine\FiniteStateMachine();
      $machine->addEvent('flip', array('on' => 'off', 'off' => 'on'));
      $machine->setInitialState('off');

### Transition from off to on

      $machine->flip();  
      echo $machine->getCurrentState();
      // prints 'on'  
      
### Transition back to off

      $machine->flip();  
      echo $machine->getCurrentState();
      // prints 'off'  

      
