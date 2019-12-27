<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Student;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class StudentsController extends Controller
{

    public function index()
    {
        // Lấy dữ liệu vào các dropdown
        $ddkhoa = array_unique(Student::pluck('khoa')->all());
        $ddvien = array_unique(Student::pluck('vien')->all());
        $ddlop = array_unique(Student::pluck('lop')->all());

        return view('students.index')->with('ddkhoa', $ddkhoa)->with('ddvien', $ddvien)->with('ddlop', $ddlop);
    }

    public function search(Request $request)
    {
        // Lấy dữ liệu từ request gửi từ form
        $vien = $request->input('vien');
        $khoa = $request->input('khoa');
        $lop = $request->input('lop');
        $mssv = $request->input('mssv');
        $hoten = $request->input('hoten');

        // Ko nhập gì hoặc là lần đầu mở ra thì sẽ không có kết quả
        if (($vien == '') && ($khoa == '') && ($lop == '') && ($mssv == '') && ($hoten == '')) {
            $students = [];
            return response()->json($students);
        } else {
            // Tìm kiếm dữ liệu
            // Ưu tiên: Tên -> MSSV -> Lớp -> Khoa/Viện -> Khóa

            if ($hoten != '') {
                // $a = split_name($hoten);
                // return response()->json($a);
                // $ho = $a[first_name];
                // $dem = $a[middle_name];
                // $ten = $a[last_name];

                // $students = DB::table('students')->where('ten', 'LIKE', '%' . $ten . '%')
                    // ->where('dem', 'LIKE', '%' . $dem . '%')
                    // ->where('ho', 'LIKE', '%' . $ho . '%')
                    // ->get();

                $students = DB::table('students')->where('ten', 'LIKE', '%'.$hoten.'%')->get();
            } else {
                if ($mssv != '') {
                    $students = DB::table('students')->where('mssv', 'LIKE', '%'.$mssv.'%')->get();
                } else {
                    if ($lop != '') {
                        $students = DB::table('students')->where('lop', $lop)->get();
                    } else {
                        if ($vien != '') {
                            $students = DB::table('students')->where('vien', $vien)->get();
                        } else {
                            $students = DB::table('students')->where('khoa', $khoa)->get();
                        }
                    }
                }
            }
            return response()->json($students);
        }
    }
    // Cắt chuỗi họ và tên
    public function split_name($name)
    {
        $parts = array();

        while (strlen(trim($name)) > 0) {
            $name = trim($name);
            $string = preg_replace('#.*\s([\w-]*)$#', '$1', $name);
            $parts[] = $string;
            $name = trim(preg_replace('#' . $string . '#', '', $name));
        }

        if (empty($parts)) {
            return false;
        }

        $parts = array_reverse($parts);
        $name = array();
        $name['first_name'] = $parts[0];
        $name['middle_name'] = (isset($parts[2])) ? $parts[1] : '';
        $name['last_name'] = (isset($parts[2])) ? $parts[2] : (isset($parts[1]) ? $parts[1] : '');

        return $name;
    }
}
