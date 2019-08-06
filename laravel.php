### Voyager Check Box ###
#########################

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use TCG\Voyager\Traits\Resizable;

class ClassName extends Model
{
    use Resizable;
}


#########################
#########################



## SEARCH SAMPLE #######
#########################


 public function blog(Request $request, $cat = null)
    {
		$services              =   Service::where('active','1')->get();
		$portfolios            =   Portfolio::where('active','1')->get();
		$sections              =   Section::where('active','1')->get();
		$teams                 =   Team::where('active','1')->get();
		$sliders               =   Slider::where('active','1')->get();
		$sections              =   Section::where('active','1')->get();
		$logos                 =   Brand::where('active','1')->get();

		$keyword               = $request->get('blogsearch');




		if ($cat) {
			// blog details
			$blogs             =   Blog::where('blog_category_id', $cat)->paginate(8);
		}
		else {
			if($keyword)
			{
				$keyword = explode(" ", $keyword);

				$query = DB::table('blogs');
				$query->where('active','1');

				foreach ($keyword as $key => $word) {
					if($key == 0) {
						$query->where('name','LIKE','%'.$word.'%');
					}
					else {
						$query->orWhere('name','LIKE','%'.$word.'%');
					}
				}
				$blogs = $query->Paginate(8);
			}
			else {
				$blogs =   Blog::where('active','1')->Paginate(8);
			}

		}




		$blogcats              =   BlogCategory::where('active', '1')->get();
		$info                  =   Page::where('slug', 'about-us')->firstOrFail();

		return view('blog', compact(
		'services',
		'portfolios',
		'teams',
		'sections',
		'info',
		'logos',
		'blogs',
		'blogcats',
		'sliders'

		));
    }
