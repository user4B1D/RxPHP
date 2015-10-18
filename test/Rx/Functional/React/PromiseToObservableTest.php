<?php


namespace Rx\Functional\React;

use Exception;
use React\Promise\Deferred;
use Rx\Disposable\CallbackDisposable;
use Rx\Functional\FunctionalTestCase;
use Rx\Observable\AnonymousObservable;
use Rx\Observable\BaseObservable;
use Rx\Observable\EmptyObservable;
use Rx\Observer\CallbackObserver;
use Rx\React\Promise;
use Rx\Subject\Subject;

class PromiseToObservableTest extends FunctionalTestCase
{
    /**
     * @test
     *
     */
    public function from_promise_success()
    {

        $d = new Deferred();

        $d->resolve(42);

        $source = Promise::toObservable($d->promise());

        $source->subscribe(new CallbackObserver(
          function ($x) {
              $this->assertEquals(42, $x);
          },
          function ($error) {
              $this->assertFalse(true);
          },
          function () {
              $this->assertTrue(true);
          }));

    }

    /**
     * @test
     *
     */
    public function from_promise_failure()
    {

        $d = new Deferred();

        $d->reject(new Exception('error'));

        $source = Promise::toObservable($d->promise());

        $source->subscribe(new CallbackObserver(
          function ($x) {
              $this->assertFalse(true);

          },
          function ($error) {
              $this->assertEquals($error, new Exception('error'));
          },
          function () {
              $this->assertFalse(true);
          }));

    }
}