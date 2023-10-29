<?php
require_once __DIR__ . '/../vendor/autoload.php';

use PhpParser\Error;
use PhpParser\NodeDumper;
use PhpParser\ParserFactory;
use PhpParser\Node;
use PhpParser\NodeTraverser;
use PhpParser\NodeVisitorAbstract;
use PhpParser\PrettyPrinter;

$expr = new PhpParser\Node\Scalar\String_('Hello World');
$echoStmt = new PhpParser\Node\Stmt\Echo_([$expr], [
    'comments' => [
        new PhpParser\Comment\Doc('/**  This program was generated from AST.' . PHP_EOL . ' Lets build more complex programs  */')
    ]
]);




/**
 * Now we will create AST for writing a function which find maximum of the array.
 * The reason to do such an exercize is to thoroughly explore php-parse library and
 * all it's type before we move on to more complicated tasks and concepts of scope.
 *
 * To write such a program we must first convert the program into AST in our head.
 */

// $max = arr[0]
$maxInit = new Node\Expr\Assign(
    new Node\Expr\Variable('max'),
    new Node\Expr\ArrayDimFetch(
        new Node\Expr\Variable('arr'),
        new PhpParser\Node\Scalar\LNumber(0)
    )
);

$contentsOfFor = [
    new Node\Stmt\If_(
        new PhpParser\Node\Expr\BinaryOp\Greater(
            new Node\Expr\Variable('num'),
            new Node\Expr\Variable('max'),
        ),
        [
            'stmts'=> [
                new Node\Stmt\Expression(
                    new PhpParser\Node\Expr\Assign(
                        new Node\Expr\Variable('max'),
                        new Node\Expr\Variable('num')
                    )
                )
            ]
        ]
    )
];

$fn  = new PhpParser\Node\Stmt\Function_('findMaxFromArray',[
    'params'=>[
        new Node\Param(new Node\Expr\Variable('arr'))
    ],
    'returnType'=>'int',
    'stmts'=>[
        new PhpParser\Node\Stmt\Expression($maxInit),
        new PhpParser\Node\Stmt\Foreach_(
            new PhpParser\Node\Expr\Variable('arr'),
            new PhpParser\Node\Expr\Variable('num'),
            [
                'stmts'=>$contentsOfFor
            ]
        )
    ]
]);
$ast = [$echoStmt,$fn];
$prettyPrinter = new PrettyPrinter\Standard;
echo $prettyPrinter->prettyPrintFile($ast);