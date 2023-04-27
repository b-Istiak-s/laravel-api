<?php
namespace App\Filters;
use Illuminate\Http\Request;

class ApiFilter{
    
    protected $safeParams = [];

    protected $columnMap = [];

    protected $operatorMap = [];

    public function transform(Request $request){
        $eloQuery = [];

        foreach($this->safeParams as $param=>$operators){
            $query = $request->query($param);

            if(!isset($query)){
                continue;
            }

            $column = $this->columnMap[$param] ?? $param;

            foreach($operators as $operator){
                if(isset($query[$operator])){
                    $eloQuery[] = [$column,$this->operatorMap[$operator],$query[$operator]];
                }
            }
        }
        return $eloQuery;
    }
<<<<<<< HEAD

=======
    
    
>>>>>>> 243e10ffe6345e88d54ad8095a407ae98d2858e9
    //without operator
    // public function transform(Request $request)
    // {
    //     $filters = [];
    //     foreach ($request->query() as $key => $value) {
    //         $filters[] = [$key, '=', $value]; 
    //     }
    //     return $filters;
    // }
}
