<?php
namespace Nap\Test\Resource;

use \Nap\Test\Uri\Stubs;

class UriMatchingTest extends \PHPUnit_Framework_TestCase
{
    /** @test **/
    public function UriWithoutParameter_DoesNotMatchResourceWithRequiredParameter()
    {
        // Arrange
        $uri = "/uri";
        $rootResource = new \Nap\Resource\Resource("Uri", "/uri", new Stubs\ParamScheme\SingleSelfRequiredIntParam());

        $matcher = new \Nap\Resource\ResourceMatcher(new \Nap\Uri\MatchableUriBuilder());

        // Act
        $matchedResource = $matcher->match($uri, array($rootResource));

        // Assert
        $this->assertNull($matchedResource);
    }

    /** @test **/
    public function UriWithIntParameter_MatchesResourceWithRequiredIntParameter()
    {
        // Arrange
        $uri = "/uri/1";
        $rootResource = new \Nap\Resource\Resource("Uri", "/uri", new Stubs\ParamScheme\SingleSelfRequiredIntParam());

        $matcher = new \Nap\Resource\ResourceMatcher(new \Nap\Uri\MatchableUriBuilder());

        // Act
        $matchedResource = $matcher->match($uri, array($rootResource));

        // Assert
        $this->assertEquals($rootResource, $matchedResource->getResource());
    }

    /** @test **/
    public function UriWithStringParameter_DoesNotMatchResourceWithRequiredIntParameter()
    {
        // Arrange
        $uri = "/uri/asd";
        $rootResource = new \Nap\Resource\Resource("Uri", "/uri", new Stubs\ParamScheme\SingleSelfRequiredIntParam());

        $matcher = new \Nap\Resource\ResourceMatcher(new \Nap\Uri\MatchableUriBuilder());

        // Act
        $matchedResource = $matcher->match($uri, array($rootResource));

        // Assert
        $this->assertNull($matchedResource);
    }

    /** @test **/
    public function UriWith3SegmentsAnd1Param_DoesNotMatchResourceWithRequiredParamAndParentWithRequiredParam()
    {
        // Arrange
        $uri = "/uri/child/1";

        $childResource = new \Nap\Resource\Resource("Child", "/child", new Stubs\ParamScheme\SingleSelfRequiredIntParam("child_id"));
        $rootResource = new \Nap\Resource\Resource("Uri", "/uri", new Stubs\ParamScheme\SingleChildRequiredIntParam("id"), array(
            $childResource
        ));


        $matcher = new \Nap\Resource\ResourceMatcher(new \Nap\Uri\MatchableUriBuilder());

        // Act
        $matchedResource = $matcher->match($uri, array($rootResource));

        // Assert
        $this->assertNull($matchedResource);
    }

    /** @test **/
    public function UriWith3SegmentsAnd2Params_MatchesResourceWithRequiredParamAndParentWithRequiredParam()
    {
        // Arrange
        $uri = "/uri/1/child/1";

        $childResource = new \Nap\Resource\Resource("Child", "/child", new Stubs\ParamScheme\SingleSelfRequiredIntParam("child_id"));
        $rootResource = new \Nap\Resource\Resource("Uri", "/uri", new Stubs\ParamScheme\SingleSelfRequiredIntParam("id"), array(
            $childResource
        ));


        $matcher = new \Nap\Resource\ResourceMatcher(new \Nap\Uri\MatchableUriBuilder());

        // Act
        $matchedResource = $matcher->match($uri, array($rootResource));

        // Assert
        $this->assertEquals($childResource, $matchedResource->getResource());
    }

    /** @test **/
    public function UriWith3SegmentsAnd1Param_MatchesResourceWithRequiredParamAndParentWithOptionalParam()
    {
        // Arrange
        $uri = "/uri/child/1";

        $childResource = new \Nap\Resource\Resource("Child", "/child", new Stubs\ParamScheme\SingleSelfRequiredIntParam("child_id"));

        $optionalParamScheme = new Stubs\ParamScheme\SingleParam(
            new Stubs\IntParam("id", false, false, "\d+", "id")
        );
        $rootResource = new \Nap\Resource\Resource("Uri", "/uri", $optionalParamScheme, array(
            $childResource
        ));


        $matcher = new \Nap\Resource\ResourceMatcher(new \Nap\Uri\MatchableUriBuilder());

        // Act
        $matchedResource = $matcher->match($uri, array($rootResource));

        // Assert
        $this->assertEquals($childResource, $matchedResource->getResource());
    }
}