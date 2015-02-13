<?php


use App\Contact;
use App\Phone;
use App\Email;
use Illuminate\Http\RedirectResponse;

class appTest extends TestCase {

	/**
	 * A basic functional test example.
	 *
	 * @return void
	 */
	public function testUnit()
	{
		//response test
		$this->call('GET', '/');
		$this->assertResponseOk();
		
		$this->call('GET', 'contacts');
		$this->assertResponseOk();
		
		$this->call('GET', 'contacts/create');
		$this->assertResponseOk();
		
		$this->call('GET', 'loadSpreadsheet');
		$this->assertResponseOk();
		
		//post test
		
		$post = Contact::create(array('first_name'=>'Edgar','last_name'=>'Forero', 'gender'=>'M', 'user_id'=>1));
		$this->assertEquals( $post->first_name, 'Edgar' );
		
		$post1 = Phone::create(array('contact_id'=>$post->id, 'phone'=>'77665544'));
		$this->assertEquals( $post1->contact_id, $post->id );
		
		$post2 = Phone::create(array('contact_id'=>$post->id, 'email'=>'edgar@toro-labs.com'));
		$this->assertEquals( $post2->contact_id, $post->id );
		
	}
}
