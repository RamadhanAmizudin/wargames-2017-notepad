<?php
header('Content-type: text/plain');
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
?>
#include <iostream>
#include <iomanip>
#include <cmath>

// I iz a flag - <?php /* WGMY:{SaAs_t00_br0k3n_4fouR_y0u} */ ?>

//  _________ 
// |(_*|=====|
// |=========|
// |=========|
//  Malaysia

class bit_flag
{
    public: bit_flag();
            void p(int);
            void lines(int);
            void b_space(int);
            void print_flag();
    
    private: int R,W,B,Y;
};

bit_flag::bit_flag()
{
    R = 177;
    W = 178;
    B = 176;
    Y = 219;
}

void bit_flag::p(int ASCII) 
{
    std::cout << char(ASCII) << char(ASCII);
}

void bit_flag::lines(int count) 
{
    for (int i = 0; i < count; i++) { p(W); p(R); }
}

void bit_flag::b_space(int i)
{
    int arr[5][8] = {
       {B, B, B, B, B, B, B, B},
       {B, B, B, Y, Y, B, B, B},
       {B, B, Y, Y, Y, Y, B, B},
       {B, Y, Y, B, B, Y, Y, B},
       {B, Y, B, B, B, B, Y, B}};
                      
    for (int j = 0; j < 8; j++) p(arr[i][j]);
}

void bit_flag::print_flag()
{
    int alg[13] = {0, 1, 2, 3, 4, 0, 1, 2, 2, 2, 1, 0, 0};
    
    for (int i : alg) 
    {
        lines(3); b_space(i); 
        std::cout << "\n";
    }
    for (int i = 0; i < 13; i++) 
    {
        std::cout << std::setw(std::abs(sin(94.26 * i / 180) * 5)); 
        lines(7); std::cout << "\n";
    }
}

int main() 
{
    bit_flag obj;
    obj.print_flag(); 
    return 0;
}
