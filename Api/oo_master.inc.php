<?php

//Include our HTML Page Class
require_once("oo_page.inc.php");

class MasterPage
{
    //-------FIELD MEMBERS----------------------------------------
    private $_htmlpage;     //Holds our Custom Instance of an HTML Page
    private $_dynamic_1;    //Field Representing our Dynamic Content #1
    private $_dynamic_2;    //Field Representing our Dynamic Content #2
    private $_dynamic_3;    //Field Representing our Dynamic Content #3
   
    
    //-------CONSTRUCTORS-----------------------------------------
    function __construct($ptitle)
    {
        $this->_htmlpage = new HTMLPage($ptitle);
        $this->setPageDefaults();
        $this->setDynamicDefaults(); 
       
    }
    
    //-------GETTER/SETTER FUNCTIONS------------------------------
    public function getDynamic1() { return $this->_dynamic_1; }
    public function getDynamic2() { return $this->_dynamic_2; } 
    public function getDynamic3() { return $this->_dynamic_3; }
    public function setDynamic1($phtml) { $this->_dynamic_1 = $phtml; }
    public function setDynamic2($phtml) { $this->_dynamic_2 = $phtml; } 
    public function setDynamic3($phtml) { $this->_dynamic_3 = $phtml; }
    public function getPage(): HTMLPage { return $this->_htmlpage; } 
    
    //-------PUBLIC FUNCTIONS-------------------------------------
                   
    public function createPage()
    {
       //Create our Dynamic Injected Master Page
       $this->setMasterContent();
       //Return the HTML Page..
       return $this->_htmlpage->createPage();
    }
    
    public function renderPage()
    {
       //Create our Dynamic Injected Master Page
       $this->setMasterContent();
       //Echo the page immediately.
       $this->_htmlpage->renderPage();
    }
    
    public function addCSSFile($pcssfile)
    {
        $this->_htmlpage->addCSSFile($pcssfile);
    }
    
    public function addScriptFile($pjsfile)
    {
        $this->_htmlpage->addScriptFile($pjsfile);
    }
    
    //-------PRIVATE FUNCTIONS-----------------------------------    
    private function setPageDefaults()
    {
        $this->_htmlpage->setMediaDirectory("css","js","fonts","img","data");
        $this->addCSSFile("site.css");
       
        $this->addScriptFile("jquery-2.2.4.js");
        $this->addScriptFile("bootstrap.js");
        $this->addScriptFile("holder.js");        
    }
    
    private function setDynamicDefaults()
    {
       
        //Set the Three Dynamic Points to Empty By Default.
        $this->_dynamic_1 = "";
        $this->_dynamic_2 = "";
        $this->_dynamic_3 = "";
    }
    
    private function setMasterContent()
    {
        
       
        
        $tmasterpage    = <<<FORM

<div id="wrapper">
<header>
<h1>Club Event Promotion Site</h1>

</header>
<nav>
			<ul>
				<li><a href="index.php">Home</a></li>
				<li><a href="Event.php">Events</a></li>
				<li><a href="Artist.php">Artists</a></li>
				<li><a href="Profile.php">Profile</a></li>
				<li class="nav-gap"></li>
				<li><a href="login.php">Login</a></li>
				<li><a href="signup.php">SignUp</a></li>
			</ul>	
		</nav>
	
	
	
	
     
   
	<div id= "wrapper">
        {$this->_dynamic_1}
		{$this->_dynamic_2}
         {$this->_dynamic_3}
    </div>

  
	</div>
	
		
    <footer>
    <ul>
        <li><a href="about.php">About us</a></li>
        <li class="footer-gap"></li>
        <li><a href="contact.php">Contact us</a></li>
        <li>Copyright &copy; 2024</li>
    </ul>
</footer>
FORM;
        $this->_htmlpage->setBodyContent($tmasterpage); 
    }
}

?>