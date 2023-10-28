<?php
require_once __DIR__.'/../vendor/autoload.php';
use PhpParser\Error;
use PhpParser\NodeDumper;
use PhpParser\ParserFactory;
use PhpParser\Node;
use PhpParser\NodeTraverser;
use PhpParser\NodeVisitorAbstract;
use PhpParser\PrettyPrinter;

$code  = file_get_contents(__DIR__.'/comment-die.php');

$parser = (new ParserFactory)->create(ParserFactory::PREFER_PHP7);
try {
    $ast = $parser->parse($code);
} catch (Error $error) {
    echo "Parse error: {$error->getMessage()}\n";
    return;
}

$traverser = new NodeTraverser();

class CommentDieVisitor extends NodeVisitorAbstract
{
    public function enterNode(Node $node){

        if($node instanceof \PhpParser\Node\Stmt\Expression && $node->expr instanceof Node\Expr\Exit_ && $node->expr->getAttribute('kind')=== Node\Expr\Exit_::KIND_DIE){
            $prettyPrinter = new PrettyPrinter\Standard;
            $nop =  new Node\Stmt\Nop();
            $comment = new \PhpParser\Comment(
                '//'.$prettyPrinter->prettyPrintExpr($node->expr),
            );
            $nop->setAttribute('comments',[$comment]);
            return $nop;
        }
        return null;
    }
}

$traverser->addVisitor(new CommentDieVisitor());
$ast = $traverser->traverse($ast);

//$dumper = new NodeDumper;
//echo $dumper->dump($ast) . "\n";

$prettyPrinter = new PrettyPrinter\Standard;
echo $prettyPrinter->prettyPrintFile($ast);
