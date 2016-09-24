<?php

namespace manrog\components\network\curl;

use InvalidArgumentException;
use manrog\components\network\curl\exceptions\CurlNotFoundException;
use PHPUnit\Framework\TestCase;

/**
 * Class UrlRequestTest
 *
 * unit tests for UrlRequest.
 *
 * @package manrog\components\network\curl
 * @version 1.0
 * @autor   Manuel Rogoll<manuel.rogoll@manrog.de>
 */
class UrlRequestTest extends TestCase
{
    /** @var UrlRequest */
    private $urlRequest;
    /** @var Curl|\PHPUnit_Framework_MockObject_MockObject */
    private $curlMock;

    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        parent::setUp();

        $this->curlMock = $this->getMockBuilder(AbstractCurl::class)
            ->disableOriginalConstructor()
            ->setMethods(
                array(
                    'init',
                    'exec',
                    'close',
                    'setopt',
                    'error',
                    'errno',
                )
            )
            ->getMockForAbstractClass();

        $this->urlRequest = new UrlRequest();
    }

    /**
     * the url request need a curl object for performing, this method is very important for functionality
     *
     * @return UrlRequest
     */
    public function testSetCurl_shouldStoreCurlObject()
    {
        $this->assertEquals($this->urlRequest, $this->urlRequest->setCurl($this->curlMock));
        $this->assertAttributeEquals($this->curlMock, 'curl', $this->urlRequest);

        return $this->urlRequest;
    }

    /**
     * @param UrlRequest $urlRequest
     *
     * @depends testSetCurl_shouldStoreCurlObject
     */
    public function testGetCurl_shouldReturnCurlObject(UrlRequest $urlRequest)
    {
        $this->assertInstanceOf(CurlInterface::class, $urlRequest->getCurl());
    }

    /**
     * @expectedException \Exception
     */
    public function testGetCurl_shouldGetExceptionBecauseObjextNotExist()
    {
        $this->urlRequest->getCurl();
    }

    /**
     * the request needs a target to get content
     *
     * @return UrlRequest
     */
    public function testSetUrl_shouldStoreTheURLForRequest()
    {
        $this->urlRequest->setUrl('http://www.manrog.de');
        $this->assertAttributeEquals('http://www.manrog.de', 'url', $this->urlRequest);

        return $this->urlRequest;
    }

    /**
     * @param UrlRequest $urlRequest
     *
     * @depends testSetUrl_shouldStoreTheURLForRequest
     */
    public function testGetUrl_shouldReturnActualURL(UrlRequest $urlRequest)
    {
        $this->assertEquals('http://www.manrog.de', $urlRequest->getUrl());
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testInvalidArgumentForSetUrl()
    {
        $this->urlRequest->setUrl(124);
    }

    public function testAddCurlOptions_shouldStoreCurlOptionInArray()
    {
        $this->urlRequest->addCurlOption(CURLOPT_RETURNTRANSFER, 1);

        $this->assertAttributeEquals(
            array(
                CURLOPT_RETURNTRANSFER => 1,
            ),
            'options',
            $this->urlRequest
        );

        return $this->urlRequest;
    }

    /**
     * @depends testAddCurlOptions_shouldStoreCurlOptionInArray
     *
     * @param \manrog\components\network\curl\UrlRequest $urlRequest
     */
    public function testRemoveCurlOption_shouldRemoveCurlOption(UrlRequest $urlRequest)
    {
        $urlRequest->removeCurlOption(CURLOPT_RETURNTRANSFER);
        $this->assertAttributeEquals(array(), 'options', $urlRequest);
    }

    /**
     * @depends testAddCurlOptions_shouldStoreCurlOptionInArray
     *
     * @param \manrog\components\network\curl\UrlRequest $urlRequest
     */
    public function testCleanCurlOption_shouldRemoveAllCurlOptions(UrlRequest $urlRequest)
    {
        $this->urlRequest->cleanCurlOptions();
        $this->assertAttributeEquals(array(), 'options', $urlRequest);
    }

    /**
     * test execution by call curl necessary commands
     */
    public function testExecute_withoutOptions()
    {
        $ch = array('pseudo resource');

        $this->curlMock->expects($this->once())
            ->method('init')
            ->with($this->equalTo('http://www.manrog.de/'))
            ->willReturn($ch);

        $this->curlMock->expects($this->once())
            ->method('setopt')
            ->with($this->equalTo($ch), $this->equalTo(CURLOPT_RETURNTRANSFER), $this->equalTo(1));

        $this->curlMock->expects($this->once())
            ->method('exec')
            ->with($this->equalTo($ch))
            ->willReturn('external content');

        $this->curlMock->expects($this->once())
            ->method('close')
            ->with($this->equalTo($ch));

        $this->urlRequest
            ->setCurl($this->curlMock)
            ->setUrl('http://www.manrog.de/')
            ->execute();

        $this->assertAttributeEquals('external content', 'content', $this->urlRequest);

        return $this->urlRequest;
    }

    /**
     * test execution by call curl necessary commands
     */
    public function testExecute_withOptions()
    {
        $ch = array('pseudo resource');

        $this->curlMock->expects($this->once())
            ->method('init')
            ->with($this->equalTo('http://www.manrog.de/'))
            ->willReturn($ch);

        $this->curlMock->expects($this->exactly(3))
            ->method('setopt')
            ->withConsecutive(
                array($this->equalTo($ch), $this->equalTo(CURLOPT_RETURNTRANSFER), $this->equalTo(1)),
                array($this->equalTo($ch), $this->equalTo(CURLOPT_BINARYTRANSFER), $this->equalTo(1)),
                array($this->equalTo($ch), $this->equalTo(CURLOPT_CONNECTTIMEOUT), $this->equalTo(0))
            );

        $this->curlMock->expects($this->once())
            ->method('exec')
            ->with($this->equalTo($ch))
            ->willReturn('external content');

        $this->curlMock->expects($this->once())
            ->method('close')
            ->with($this->equalTo($ch));

        $this->urlRequest
            ->setCurl($this->curlMock)
            ->addCurlOption(CURLOPT_RETURNTRANSFER, 1)
            ->addCurlOption(CURLOPT_BINARYTRANSFER, 1)
            ->addCurlOption(CURLOPT_CONNECTTIMEOUT, 0)
            ->setUrl('http://www.manrog.de/')
            ->execute();

        $this->assertAttributeEquals('external content', 'content', $this->urlRequest);
    }

    /**
     * @depends testExecute_withoutOptions
     *
     * @param \manrog\components\network\curl\UrlRequest $urlRequest
     */
    public function testGetContent(UrlRequest $urlRequest)
    {
        $this->assertEquals('external content', $urlRequest->getContent());
    }

    public function testGetErrorBeforeRequestPerforms()
    {
        $this->assertEquals('', $this->urlRequest->getError());
    }

    public function testGetErrnoBeforeRequestPerfoms()
    {
        $this->assertEquals(0, $this->urlRequest->getErrno());
    }


    /**
     * test get getError after performing request with available curl handle
     */
    public function testGetErnAfterRequestsPerfoms()
    {
        $ch = array('pseudo resource');

        $this->curlMock->expects($this->once())
            ->method('init')
            ->with($this->equalTo('http://www.manrog.de/'))
            ->willReturn($ch);

        $this->curlMock->expects($this->once())
            ->method('error')
            ->with($this->equalTo($ch))
            ->willReturn('');

        $this->urlRequest->setCurl($this->curlMock)->setUrl('http://www.manrog.de/')->execute();

        $this->assertEquals('', $this->urlRequest->getError());
    }

    /**
     * test getErrno after performing request with available curl handle
     */
    public function testGetErrorAfterRequestsPerfoms()
    {
        $ch = array('pseudo resource');

        $this->curlMock->expects($this->once())
            ->method('init')
            ->with($this->equalTo('http://www.manrog.de/'))
            ->willReturn($ch);

        $this->curlMock->expects($this->once())
            ->method('errno')
            ->with($this->equalTo($ch))
            ->willReturn(0);

        $this->urlRequest->setCurl($this->curlMock)->setUrl('http://www.manrog.de/')->execute();

        $this->assertEquals(0, $this->urlRequest->getErrno());
    }
}
