<?php
require_once __DIR__.'/../vendor/autoload.php';
use PhpParser\Error;
use PhpParser\NodeDumper;
use PhpParser\ParserFactory;
use PhpParser\Node;
use PhpParser\NodeTraverser;
use PhpParser\NodeVisitorAbstract;
use PhpParser\PrettyPrinter;

$code  = file_get_contents(__DIR__.'/super-globals.php');

$parser = (new ParserFactory)->create(ParserFactory::PREFER_PHP7);
try {
    $ast = $parser->parse($code);
} catch (Error $error) {
    echo "Parse error: {$error->getMessage()}\n";
    return;
}

$traverser = new NodeTraverser();

class CollectSuperGlobals extends NodeVisitorAbstract
{
    private $superglobals = [
        '_COOKIE',
        '_REQUEST',
        '_SERVER',
        '_GET',
        '_POST',
        '_FILES'
    ];

    private $output = [];

    public function enterNode(Node $node){
        if($node instanceof PhpParser\Node\Expr\Variable && in_array($node->name,$this->superglobals)){
           $this->output[] = $node->name.' used on line number '.$node->getStartLine();
        }
        return null;
    }

    public function getOutput(){
        return $this->output;
    }
}

$collecter = new CollectSuperGlobals();
$traverser->addVisitor($collecter);
 $traverser->traverse($ast);

 print_r($collecter->getOutput());