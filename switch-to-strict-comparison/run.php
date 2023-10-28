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

class SwitchToStrict extends NodeVisitorAbstract
{
    public function enterNode(Node $node){
        if($node instanceof PhpParser\Node\Expr\BinaryOp\Equal){
          return new PhpParser\Node\Expr\BinaryOp\Identical($node->left,$node->right);
        }
        if($node instanceof PhpParser\Node\Expr\BinaryOp\NotEqual){
            return new PhpParser\Node\Expr\BinaryOp\NotIdentical($node->left,$node->right);
        }
        return null;
    }
}

$traverser->addVisitor(new SwitchToStrict());
$ast = $traverser->traverse($ast);

//$dumper = new NodeDumper;
//echo $dumper->dump($ast) . "\n";

$prettyPrinter = new PrettyPrinter\Standard;
echo $prettyPrinter->prettyPrintFile($ast);
