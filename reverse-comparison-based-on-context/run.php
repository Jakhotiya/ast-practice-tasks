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
    private $isInMethod = false;
    public function enterNode(Node $node){
        if($node instanceof Node\Stmt\ClassMethod){
            $this->isInMethod = true;
            return null;
        }

        if($node instanceof PhpParser\Node\Expr\BinaryOp\Smaller &&  $this->isInMethod){
            return new PhpParser\Node\Expr\BinaryOp\Greater($node->left,$node->right);
        }
        if($node instanceof PhpParser\Node\Expr\BinaryOp\SmallerOrEqual && $this->isInMethod){
            return new PhpParser\Node\Expr\BinaryOp\GreaterOrEqual($node->left,$node->right);
        }
        if($node instanceof PhpParser\Node\Expr\BinaryOp\GreaterOrEqual && $this->isInMethod){
            return new PhpParser\Node\Expr\BinaryOp\SmallerOrEqual($node->left,$node->right);
        }
        if($node instanceof PhpParser\Node\Expr\BinaryOp\Greater &&  $this->isInMethod){
            return new PhpParser\Node\Expr\BinaryOp\Smaller($node->left,$node->right);
        }

        return null;
    }

    public function leaveNode(Node $node){
        if($node instanceof Node\Stmt\ClassMethod){
            $this->isInMethod = false;
        }
    }
}

$traverser->addVisitor(new ReverseComparison());
$ast = $traverser->traverse($ast);

//$dumper = new NodeDumper;
//echo $dumper->dump($ast) . "\n";

$prettyPrinter = new PrettyPrinter\Standard;
echo $prettyPrinter->prettyPrintFile($ast);
