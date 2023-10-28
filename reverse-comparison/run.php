<?php
require_once __DIR__.'/../vendor/autoload.php';
use PhpParser\Error;
use PhpParser\NodeDumper;
use PhpParser\ParserFactory;
use PhpParser\Node;
use PhpParser\NodeTraverser;
use PhpParser\NodeVisitorAbstract;
use PhpParser\PrettyPrinter;

$code  = file_get_contents(__DIR__.'/hello-world.php');

$parser = (new ParserFactory)->create(ParserFactory::PREFER_PHP7);
try {
    $ast = $parser->parse($code);
} catch (Error $error) {
    echo "Parse error: {$error->getMessage()}\n";
    return;
}

$traverser = new NodeTraverser();

class ReverseComparison extends NodeVisitorAbstract
{
    public function enterNode(Node $node){
        if($node instanceof PhpParser\Node\Expr\BinaryOp\Smaller){
            return new PhpParser\Node\Expr\BinaryOp\Greater($node->left,$node->right);
        }
        if($node instanceof PhpParser\Node\Expr\BinaryOp\SmallerOrEqual){
            return new PhpParser\Node\Expr\BinaryOp\GreaterOrEqual($node->left,$node->right);
        }
        if($node instanceof PhpParser\Node\Expr\BinaryOp\GreaterOrEqual){
            return new PhpParser\Node\Expr\BinaryOp\SmallerOrEqual($node->left,$node->right);
        }
        if($node instanceof PhpParser\Node\Expr\BinaryOp\Greater){
            return new PhpParser\Node\Expr\BinaryOp\Smaller($node->left,$node->right);
        }
        return null;
    }
}

$traverser->addVisitor(new ReverseComparison());
$ast = $traverser->traverse($ast);

//$dumper = new NodeDumper;
//echo $dumper->dump($ast) . "\n";

$prettyPrinter = new PrettyPrinter\Standard;
echo $prettyPrinter->prettyPrintFile($ast);
