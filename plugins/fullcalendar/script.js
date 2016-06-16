$(function(){  
  
    $('#calendar').fullCalendar({  
        header: {  
            left: 'prev,next today',    
            center: 'title',  
            right: 'month,agendaWeek,agendaDay',  
        },    
        events: {  
            url: 'data_events.php?gData=1',  
            error: function() {  
  
            }  
        },      
        eventLimit:true,  
        lang: 'th',  
        dayClick: function(date, jsEvent, view) { // เมื่อคลิกที่วันที่ใดๆ ในปฏิทิน  
              
            // เราจะใช้แค่เมื่อคลิกในหน้า view month เท่านั้น  
            if(view.name=="month"){ // ให้ทำงานต่อเมื่อ หน้า view ขณะนั้นเป็น month  
                $('#calendar').fullCalendar('changeView','basicDay');  
                $('#calendar').fullCalendar('gotoDate',date.format());  
            }  
  
        } ,      
    viewRender:function( view, element ){  
        setTimeout(function(){  
            var oldYear =$(".fc-toolbar").find(".fc-center").text();      
            oldYear = $.trim(oldYear);  
            var oldY = oldYear.substr(-4);  
            var newY = parseInt(oldY)+543;  
            oldYear = oldYear.replace(oldY,newY);  
            $(".fc-toolbar").find(".fc-center").find("h2").text(oldYear);         
        },10);  
    }    
    });  
       
});