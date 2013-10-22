<?php
/**
 * A Try to make loans work
 * @from https://github.com/andraskende/cakephp-shopping-cart/
 */
class CartComponent extends Component {
    public $components = array('Session');

    public $controller;

    public $maxQuantity = 99;

    public function __construct(ComponentCollection $collection, $settings = array()) {
        $this->controller = $collection->getController();
        parent::__construct($collection, array_merge($this->settings, (array)$settings));
    }

    public function startup(Controller $controller) {
        //$this->controller = $controller;
    }

    public function add($id, $quantity = 1) {
        if(!is_numeric($quantity)) {
            $quantity = 1;
        }

        $quantity = abs($quantity);

        if($quantity > $this->maxQuantity) {
            $this->remove($id);
            return;
        }
        if($quantity == 0) {
            $this->remove($id);
            return;
        }

        $book = $this->controller->Book->find('first', array(
                'recursive' => -1,
                'conditions' => array(
                    'Book.id' => $id
                )
            )
        );
        if(empty($book)) {
            return false;
        }

        $data['book_id'] = $book['Book']['id'];
        $data['title'] = $book['Book']['title'];
        $data['quantity'] = $quantity;
        $data['Book'] = $book['Book'];
        $this->Session->write('Shop.OrderItem.' . $id, $data);
        $this->Session->write('Shop.Order.shop', 1);

        $this->Cart = ClassRegistry::init('Cart');

        $cartdata['Cart']['sessionid'] = $this->Session->id();
        $cartdata['Cart']['quantity'] = $quantity;
        $cartdata['Cart']['book_id'] = $book['Book']['id'];
        $cartdata['Cart']['title'] = $book['Book']['title'];

        $existing = $this->Cart->find('first', array(
                'recursive' => -1,
                'conditions' => array(
                    'Cart.sessionid' => $this->Session->id(),
                    'Cart.book_id' => $book['Book']['id'],
                )
            )
        );

        if($existing) {
            $cartdata['Cart']['id'] = $existing['Cart']['id'];
        } else {
            $this->Cart->create();
        }

        $this->Cart->save($cartdata, false);
        $this->cart();
        return $book;
    }

    public function remove($id) {
        if($this->Session->check('Shop.OrderItem.' . $id)) {
            $book = $this->Session->read('Shop.OrderItem.' . $id);
            $this->Session->delete('Shop.OrderItem.' . $id);

            ClassRegistry::init('Cart')->deleteAll(
                array(
                    'Cart.sessionid' => $this->Session->id(),
                    'Cart.book_id' => $id,
                ),
                false
            );

            $this->cart();
            return $book;
        }
        return false;
    }

    public function cart() {
        $shop = $this->Session->read('Shop');
        $quantity = 0;
        $order_item_count = 0;

        if (count($shop['OrderItem']) > 0) {
            foreach ($shop['OrderItem'] as $item) {
                $quantity += $item['quantity'];
                $order_item_count++;
            }
            $d['order_item_count'] = $order_item_count;
            $this->Session->write('Shop.Order', $d + $shop['Order']);
            return true;
        }
        else {
            $d['quantity'] = 0;
            $this->Session->write('Shop.Order', $d + $shop['Order']);
            return false;
        }
    }

    public function clear() {
        ClassRegistry::init('Cart')->deleteAll(array('Cart.sessionid' => $this->Session->id()), false);
        $this->Session->delete('Shop');
    }

}