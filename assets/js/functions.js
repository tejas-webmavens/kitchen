/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


function set_page_url(val,current_url)
{             
    url=current_url+val;        
    if(url!='')
        window.location.href =url; 
}
