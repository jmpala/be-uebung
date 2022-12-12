// <?php
// deprecated
//
//namespace Unit\Framework\Session;
//
//use Framework\Session\SessionManager;
//use PHPUnit\Framework\TestCase;
//
//class SessionManagerTest extends TestCase
//{
//    public function setUp(): void
//    {
//        session_start();
//    }
//
//    // after each test
//    public function tearDown(): void
//    {
//        session_destroy();
//    }
//
//    public function test_session_manager_exist(): void
//    {
//        $sessionManager = new SessionManager();
//        $this->assertNotNull($sessionManager);
//    }
//
//    public function test_add_session_value(): void
//    {
//        $sessionManager = new SessionManager();
//        $key = 'test';
//        $value = 'test';
//        $sessionManager->add($key, $value);
//        $this->assertEquals($value, $sessionManager->get($key));
//    }
//
//    public function test_user_is_logged_in(): void
//    {
//        $sessionManager = new SessionManager();
//        $key = SessionManager::$LOGGED_IN;
//        $value = true;
//        $sessionManager->add($key, $value);
//        $this->assertEquals($value, $sessionManager->get($key));
//    }
//
//    public function test_user_is_not_logged_in(): void
//    {
//        $sessionManager = new SessionManager();
//        $key = SessionManager::$LOGGED_IN;
//        $value = false;
//        $sessionManager->add($key, $value);
//        $this->assertEquals($value, $sessionManager->get($key));
//    }
//
//    public function test_log_user_in(): void
//    {
//        $sessionManager = new SessionManager();
//        $sessionManager->logIn();
//        $this->assertEquals(true, $sessionManager->get(SessionManager::$LOGGED_IN));
//    }
//
//    public function test_log_user_out(): void
//    {
//        $sessionManager = new SessionManager();
//        $sessionManager->logIn();
//        $sessionManager->logOut();
//        $this->assertEquals(false, $sessionManager->get(SessionManager::$LOGGED_IN));
//    }
//
//    public function test_session_isLoggedIn(): void
//    {
//        $sessionManager = new SessionManager();
//        $sessionManager->logIn();
//        $this->assertEquals(true, $sessionManager->isLoggedIn());
//    }
//
//    public function test_save_last_request_timestamp(): void
//    {
//        $sessionManager = new SessionManager();
//        $sessionManager->updateTimestamp();
//        self::assertNotNull($sessionManager->get(SessionManager::$LAST_REQUEST_TIMESTAMP));
//    }
//
//    public function test_destroy_session(): void
//    {
//        $sessionManager = new SessionManager();
//        $sessionManager->logIn();
//        $sessionManager->logOut();
//        $this->assertEquals(false, $sessionManager->get(SessionManager::$LOGGED_IN));
//    }
//}