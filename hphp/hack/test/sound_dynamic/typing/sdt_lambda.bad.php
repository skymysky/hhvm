<?hh
// Copyright (c) Facebook, Inc. and its affiliates. All Rights Reserved.
<<file:__EnableUnstableFeatures('upcast_expression')>>

// Not SDT
class C { }

// Explicit SDT lambda, unenforced explicit parameter type
function explicit_nonenforced_nondynamic():void {
  $f = <<__SupportDynamicType>> (vec<C> $x) ==> new C();
}

<<__SupportDynamicType>>
class D { }

<<__SupportDynamicType>>
class E {
  public function foo():D { return new D(); }
}

function expectD(D $n):void { }

function testit():void {
  $f = <<__SupportDynamicType>> (vec<E> $v):D ==> {
    $x = $v[0]->foo();
    // should be an error in check under dynamic
    expectD($x);
    return $x;
  };
}
