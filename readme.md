# Working with Abstract syntax trees
Meta programming is important skill for developers.
There are two key areas to know well.
1. Working with Abstract syntax trees (AST's)
2. Reflection

This repositories is list of easy exercises to 
get comfortable with working with AST's the node classes,
node visitor pattern, trees and recursion in general.

## Prerequisites
1. Know basic recursion.
2. Practice basic tree traversal.
3. Use a library to generate AST. For php this repo uses nikic/php-parser

## Tasks
1. Reverse the Hello world string in the given Hello world program
2. Remove comments from the program
3. comment out all die statements in the program
4. print all the lines that use super global variable.
5. Reverse comparison operator in all if conditions in program
6. Switch to strict comparison,convert == operator to === operator and != to !==
7. Reverse an operator only if it is part of a method. functions and code in global scope should be left untouched.
8. Reverse operator only in ternary condition
9. Given a variable name as input print the type of the variable.
10. print variables that have been typecasted.
11. Create Hello world program by directly building an AST
12. If a class extends another class, print the parent class name.
13. Print the fully qualified name of the class

There is one task above for building program by hand-coding it's AST. Why would you do such a thing?
I generated *find maximum from array* program by writing the AST. While doing this I had to go through all the 
available Expression and Statements. I was searching for which nodes to use. Sometimes I had to generate the AST and take a hint. 
While doing this I got very familiar with different nodes and properties they have.

I feel this level of comfort is important before moving on to building tools with AST's.
If you were to write a phpstan/phan/phpmd plugin and you were frustrated with basics, you would give up. 

## Recommended reading
1. [Crafting Interpreters](https://craftinginterpreters.com/)
2. [Writing an Interpreter in Go](https://interpreterbook.com/)