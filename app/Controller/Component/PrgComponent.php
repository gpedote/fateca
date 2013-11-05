<?php
App::uses('Component', 'Controller');
/**
 * Prg Controller
 *
 */
class PrgComponent extends Component {
    
/**
 * Components
 *
 * @var array
 */
    public $components = array('Session');

    public $controller;

    public function __construct(ComponentCollection $collection, $settings = array()) {
        $this->controller = $collection->getController();
        parent::__construct($collection, array_merge($this->settings, (array)$settings));
    }

/**
 * @param mixed $url
 * @param bool $useReferer
 * returns nothing and automatically redirects
 * 2010-11-06 ms
 */
    public function autoRedirect($whereTo, $useReferer = true) {
        if ($useReferer && $this->Controller->referer() != '/' . $this->Controller->params['url']['url']) {
            $this->Controller->redirect($this->Controller->referer($whereTo, true));
        } else {
            $this->Controller->redirect($whereTo);
        }
    }
 
/**
 * should be a 303, but:
 * Note: Many pre-HTTP/1.1 user agents do not understand the 303 status. When interoperability with such clients is a concern, the 302 status code may be used instead, since most user agents react to a 302 response as described here for 303.
 * @see http://en.wikipedia.org/wiki/Post/Redirect/Get
 * @param mixed $url
 * TODO: change to 303 with backwardscompatability for older browsers?
 * 2011-06-14 ms
 */
    public function postRedirect($whereTo, $status = 302) {
        $this->controller->redirect($whereTo, $status);
    }
 
/**
 * only redirect to itself if cookies are on
 * prevents problems with lost data
 * Note: Many pre-HTTP/1.1 user agents do not understand the 303 status. When interoperability with such clients is a concern, the 302 status code may be used instead, since most user agents react to a 302 response as described here for 303.
 * @see http://en.wikipedia.org/wiki/Post/Redirect/Get
 * TODO: change to 303 with backwardscompatability for older browsers?
 * 2011-08-10 ms
 */
    public function prgRedirect($status = 302) {
        if (!empty($_COOKIE[Configure::read('Session.cookie')])) {
            return $this->controller->redirect('/' . $this->controller->params['url']['url'], $status);
        }
    }
}