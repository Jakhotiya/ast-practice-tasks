<?php
require_once __DIR__.'/../vendor/autoload.php';
use PhpParser\Error;
use PhpParser\NodeDumper;
use PhpParser\ParserFactory;
use PhpParser\Node;
use PhpParser\NodeTraverser;
use PhpParser\NodeVisitorAbstract;
use PhpParser\PrettyPrinter;

$code  = file_get_contents(__DIR__.'/remove-comments.php');

$parser = (new ParserFactory)->create(ParserFactory::PREFER_PHP7);
try {
    $ast = $parser->parse($code);
} catch (Error $error) {
    echo "Parse error: {$error->getMessage()}\n";
    return;
}

$traverser = new NodeTraverser();

class RemoveCommentsVisitor extends NodeVisitorAbstract
{
    public function enterNode(Node $node){
        $comments = $node->getComments();
        if(count($comments)){
            $node->setAttribute('comments', []);
            return $node;
        }
        return null;
    }
}

$traverser->addVisitor(new RemoveCommentsVisitor());
$ast = $traverser->traverse($ast);

//$dumper = new NodeDumper;
//echo $dumper->dump($ast) . "\n";

$prettyPrinter = new PrettyPrinter\Standard;
echo $prettyPrinter->prettyPrintFile($ast);
