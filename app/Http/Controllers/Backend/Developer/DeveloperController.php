<?php
namespace App\Http\Controllers\Backend\Developer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\SubMenu;
use App\Models\ActionMenu;
use App\Http\Controllers\Fontawesome;

class DeveloperController extends Controller
{
    public function __construct() {
        //
    }

    // Menu List
    public function index()
    {
        $menus = Menu::get();
        $subMenus = SubMenu::get();
        $actionMenus = ActionMenu::get();
    	return view('backend.pages.developer.index', compact('menus','subMenus','actionMenus'));
    }

    // Menu Add
    public function MenuAdd()
    {
        $fontawesome = json_encode(Fontawesome::list());
    	return view('backend.pages.developer.add_menu', compact('fontawesome'));    	
    }

    // Edit Menus
    public function MenuEdit($type, $id) 
    {
        $fontawesome = json_encode(Fontawesome::list());
        return view('backend.pages.developer.edit_menu', compact('type', 'id', 'fontawesome'));
    }

    // Delete menus
    public function MenuDelete($type, $id) 
    {
        // Delete Menu with Sub Menu and Action Menu
        if($type == 'menu'){
            $menu = Menu::where('id', $id);
            if($menu->first()->SubMenus->count() > 0){
                $SubMenus = $menu->first()->SubMenus;
                foreach ($SubMenus as $SubMenu) {
                    $SubMenu_next = SubMenu::where('id', $SubMenu->id);
                    
                    if($SubMenu_next->first()->ActionMenus->count() > 0)
                    {
                        $actionMenus = $SubMenu_next->first()->ActionMenus;
                        foreach ($actionMenus as $actionMenu) {
                            ActionMenu::where('id', $actionMenu->id)->delete();                    
                        }
                    }
                    $SubMenu->delete();
                }
            }
            $menu->delete();
        }

        // Delete SubMenu with Action Menu
        else if($type == 'sub_menu'){
            $SubMenu = SubMenu::where('id', $id);

            if($SubMenu->first()->ActionMenus->count() > 0)
            {
                $actionMenus = $SubMenu->first()->ActionMenus;
                foreach ($actionMenus as $actionMenu) {
                    ActionMenu::where('id', $actionMenu->id)->delete();                    
                }
            }
            $SubMenu->delete();
        }

        // Delete Action Menu
        else if($type == 'action_menu'){
            ActionMenu::where('id', $id)->delete();
        }

        return redirect()->back();
    }


    // Language
    public function language()
    {
        
        $files = json_decode($this->getAllLanFile('backend'));

        return view('backend.pages.developer.language', compact('files'));
    }
    // Language ‍Store
    public function languageStore(Request $request)
    {
        $request->validate([
            'tag'       => 'required',
            'name_en'   => 'required',
            'name_en'   => 'required',
            'name_bn'   => 'required',
            'type'      => 'required',
        ]);

        $file_path_en = resource_path("lang\\en\\$request->type\\").($request->new_file ? $request->new_file : $request->file).".php";
        $file_path_bn = resource_path("lang\bn\\$request->type\\").($request->new_file ? $request->new_file : $request->file).".php";

        if($request->new_file){
            if(!file_exists($file_path_en) && !file_exists($file_path_bn)){
                $en_new_file = fopen($file_path_en, 'w');
                $bn_new_file = fopen($file_path_bn, 'w'); 
                fwrite($en_new_file, "<?php \n\t\rreturn [\n\t\r];");
                fwrite($bn_new_file, "<?php \n\t\rreturn [\n\t\r];");  
                fclose($en_new_file);
                fclose($bn_new_file);               
            }
        }else{
            $request->validate([
                'file' => 'required',
            ]);
        }

        if(file_exists($file_path_en) && file_exists($file_path_bn))
        {
            $this->documentLines($file_path_en,  $request->tag,  $request->name_en);
            $this->documentLines($file_path_bn,  $request->tag,  $request->name_bn);
        }

        session()->flash('success', "New Localization is saved... ✔");
        return redirect()->back();
    }

    private function documentLines($file, $tag, $val)
    {
        $lines = file($file);
        $total_line = count($lines);
        unset($lines[$total_line-1]);
        $lines[] = "\t'$tag'=>'$val',\r\n";
        $lines[] = "];";
        $new_lines = array_unique($lines);
        $lineAsStr = "";
        foreach ($new_lines as $line) {
            $lineAsStr .= $line;
        }

        $open_file = fopen($file, 'w');
        fwrite($open_file, $lineAsStr);
        fclose($open_file);
        return $lines;
    }

    // Get All Files
    public function getAllLanFile($holder)
    {
        $file_path_en = resource_path("lang\\en\\$holder\\");
        $files = [];

        if(file_exists($file_path_en)){
            $files_with_crack = scandir($file_path_en);
            foreach ($files_with_crack as $key => $value) {
                if(1 < $key){
                    $files[] = str_replace('.php', '', $value);
                }
            }
        }

        return json_encode($files);
    }
}
