#Shennong — inspecting (PHP) language behaviors by yourself

![Shennong](http://upload.wikimedia.org/wikipedia/commons/thumb/0/0e/Shinno_%28Shennong%29_derivative.jpg/330px-Shinno_%28Shennong%29_derivative.jpg)

> Shennong was a Chinese culture hero who tasted various herbs to discover their qualities.

Inspired by some [article](http://www.virendrachandak.com/techtalk/php-isset-vs-empty-vs-is_null/) and [article](http://whydoesitsuck.com/why-does-php-suck/), I want to check behaviors of PHP functions by myself. Then, here comes the Shennong.

In the past, Shennong must to taste the hrebs by himself. Now, the digital shennong can arrange set of testers (aka *Lab Rat* or *Guinea Pig*) to handle the execution.


##How it works?

1. Create a `Shennong`
2. Add different `tester` which wraps your testing interest into `callable`
3. Give testing inputs.
4. Taste them!

Shennong will loop through each test input and feed it to all the tester one by one.

Keeping the testing result, Shennong can give you a simple HTML table for comparison.

*You can also add attributes to the dom result (by implementing `markLabel` method) and apply nice CSS styles on them.*

##Example

Say, I want to check the reaction of **Fool** and **Wise** when they meet **truth** and **lie**.

1. Create a Shennong

	```php
	$shennong = new Shennong('truth');
	```
	
2. Add **Fool** and **Wise** testers

	
	```php	
	$shennong->addTesters('fool', function($input)  {
   		return 'yes';
	});
	$shennong->addTesters('wise', function($input)  {
		return $input === 'truth' ? 'yes' : 'wake up';
	});
	```	

3. Give testing inputs

	```php	
	$shennong->addTestInputs(array(
   		'truth',
	    'lie'
	));
	```	
	
4. Taste them!

	```php
	$shennong->taste();
	$shennong->jotDownResult();
	```	
	
### here's the result

| [truth] test  | fool          | wise      |
| ------------- |:-------------:|:---------:|
| 'truth'       | 'yes'         | 'yes'     |
| 'lie'         | 'yes'         | 'wake up' |
