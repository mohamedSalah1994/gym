<template>
    <div >
         <div class="modal fade" id="booking_message" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <p v-if="BookingResponse" class="errormessagestyle">{{bookingMess}}</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">{{closebtn}}</button>
        </div>
      </div>
      
    </div>
  </div>
          <section>
       
     <div class="container">
         <div class="row">
           <div class="col-lg-6 col-md-6 pd-10">
                <!-- Responsive calendar - START -->
                <div class="responsive-calendar rtl">
                    <div class="controls clearfix">
                        <a title="Previous" class="pull-left" @click="previousMonth()" v-if="!today.isSame(currentMoment, 'M')">
                            <div class="arrow-icon">
                               <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-left" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
  <path fill-rule="evenodd" d="M5.854 4.646a.5.5 0 0 1 0 .708L3.207 8l2.647 2.646a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 0 1 .708 0z"/>
  <path fill-rule="evenodd" d="M2.5 8a.5.5 0 0 1 .5-.5h10.5a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"/>
</svg>
                            </div>
                        </a>
                        <h4><span>{{currentMoment.format('MMMM')}}</span> <span>{{currentMoment.format('YYYY')}}</span></h4>
                        <a title="Next" class="pull-right" @click="nextMonth()">
                            <div class="arrow-icon">
                                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-right" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
  <path fill-rule="evenodd" d="M10.146 4.646a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L12.793 8l-2.647-2.646a.5.5 0 0 1 0-.708z"/>
  <path fill-rule="evenodd" d="M2 8a.5.5 0 0 1 .5-.5H13a.5.5 0 0 1 0 1H2.5A.5.5 0 0 1 2 8z"/>
</svg>
                            </div>
                        </a>
                    </div>
                    <div class="day-headers">
                        <div class="day header">Sun</div>
                        <div class="day header">Mon</div>
                        <div class="day header">Tue</div>
                        <div class="day header">Wed</div>
                        <div class="day header">Thu</div>
                        <div class="day header">Fri</div>
                        <div class="day header">Sat</div>
                    </div>
                    <div  class="day-blocks" data-group="days" style="">
                       
                        <div v-for="(day,ind) of calender" v-if="ind <= 34" :class='{"today": day.isSame(today, "day") , "not-current" : !day.isSame(currentMoment, "M") , "active" : selectedDay == day}'@click="selectDay(day)" class="day future" style="transform: rotateY(0deg); backface-visibility: hidden; transition: -webkit-transform 0.5s ease 0s;">
                            <a>
                                <div>{{day | dayNumber}}</div></a>
    </div>
                    </div>
                </div>
            </div>
             <div class="col-lg-6">
                 <div class="No_Slots text-center" v-if="!selectedDay">
                                <img src="/assets/img/master/no-timeslots.png" border="0" width="58" height="58">
                                <h3 style="margin-top: 25px;">{{selectdaytobook}}</h3>
                            </div>
    <div class="col-lg-12 list-reserve-block" v-if="selectedDay">
        <div ><button type="button" class="close"  data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true"></span></button><div class="row">
            <div class="col-lg-12 col-md-12"><div class="duration-title"> <label>{{selectedDay.format('dddd LL')}} </label></div>
                
                <div class="times-booking" v-for="slot in availableTimeSlots">
                    <div class="row">
                        <div class="col-lg-4">
                            <a v-if="slot.available > 0 && slot.booked == 0" type="button" style="font-size: small;" class="primary-btn" @click="bookTimeSlot(slot)">{{booknowText}}</a>
                            <a v-if="slot.booked > 0"  type="button" style="font-size: small;padding: 8px 19px;background:#cc2e2e" class="primary-btn" @click="cancelTimeSlot(slot)">{{cancelnowText}}</a>
    </div>
                        <div class="col-lg-6"><label>{{slot.to | toSlot}}</label>
                    <label> - </label>
                    <label>
                    {{slot.from | fromSlot}}</label></div>
                        <div class="col-lg-2">   <span class="badge badge-info">{{slot.available}}</span></div>
    
    </div>
                   
                    
                     
                    
                   
                   
<!--                    <span class="duration-title">  (60 minutes)</span>-->
    
    </div>
                
               
    
    </div></div></div></div>
    </div>
         </div>
        </div>
        
    </section>
    </div>
</template>

<script>
    export default {
        props : ['selectdaytobook'],
        data(){
            return {
                today : moment(),
                currentMonth : moment().format('MMMM'),
                currentYear : moment().format('YYYY'),
                currentMoment : moment(),
                calender  : [],
                selectedDay : null,
                availableTimeSlots : [],
                bookingMess : '',
                BookingResponse : false,
                closebtn : '',
                booknowText : '',
                cancelnowText : '',
            }
        },
        mounted() {
            let calendar = [];
            const startDay = moment().clone().startOf('month').startOf('week');
            const endDay = moment().clone().endOf('month').endOf('week');

            let date = startDay.clone().subtract(1, 'day');

            while (date.isBefore(endDay, 'day')) {
                calendar.push(date.add(1, 'day').clone())
            }
                this.calender = calendar;
            console.log('Component mounted.')
        },
        methods :{
            nextMonth(){
                this.currentMoment = this.currentMoment.add(1,'M');
                this.calender = this.getnewCalender(this.currentMoment);
            },previousMonth(){
                this.currentMoment = this.currentMoment.subtract(1,'M');
                this.calender = this.getnewCalender(this.currentMoment);
            },
            getnewCalender(newDate){
            let calendar = [];
            const startDay = newDate.clone().startOf('month').startOf('week');
            const endDay = newDate.clone().endOf('month').endOf('week');

            let date = startDay.clone().subtract(1, 'day');

            while (date.isBefore(endDay, 'day')) {
                calendar.push(date.add(1, 'day').clone())
            }
                return calendar;
            },
            selectDay(day){
                if(moment(day).format('YYYY-MM-DD') >= moment(this.today).format('YYYY-MM-DD')){
                this.selectedDay = day;
                axios.post('/timeslots',{day : this.selectedDay.format('YYYY-MM-DD')}).then((data)=>{
                    this.availableTimeSlots = data.data.available;
                    this.booknowText = data.data.bookBtnText;
                    this.cancelnowText = data.data.cancelBtnText;
                    console.log(data);
                    //booking_message
                }).catch((error)=>{
                    console.log(error);
                });
                    }
            },
            bookTimeSlot(selectedSlot){
            $(".main_sppiner").removeClass('hideloader');
                  axios.post('/bookTimeSlot',{day : selectedSlot.day , from : selectedSlot.from , to : selectedSlot.to}).then((data)=>{
                    console.log(data);
                      if(data.data.status == "failed"){
                          this.bookingMess = data.data.message;
                          this.BookingResponse = true;
                          this.closebtn = data.data.closebtn;
                          $("#booking_message").modal('show');
                      }else if(data.data.status == "done"){
                          this.bookingMess = data.data.message;
                          this.BookingResponse = true;
                          this.closebtn = data.data.closebtn;
                          this.cancelnowText = data.data.cancelBtnText;
                          selectedSlot.booked = data.data.booked;
                          selectedSlot.available = selectedSlot.available - 1 ;
                          $("#booking_message").modal('show');
                      }
                      $(".main_sppiner").addClass('hideloader');
                }).catch((error) =>{
                         $(".main_sppiner").addClass('hideloader');
                         });
            },
            cancelTimeSlot(selectedSlot){
                $(".main_sppiner").removeClass('hideloader');
                     axios.post('/cancelTimeSlot',{day : selectedSlot.day , from : selectedSlot.from , to : selectedSlot.to}).then((data)=>{
                    console.log(data);
                         if(data.data.status == 'done'){
                             selectedSlot.booked = 0;
                             selectedSlot.available = data.data.available;
                         }
                 
                      $(".main_sppiner").addClass('hideloader');
                }).catch((error) =>{
                         $(".main_sppiner").addClass('hideloader');
                         });
            }
         
        },
        computed:{
            
        }
        ,filters  :{
            dayNumber(val){
                return val.date();
                
            },
            fromSlot(val){
                return moment(val).format('hh:mm a');
            },
            toSlot(val){
                 return moment(val).format('hh:mm a');
            }
        }
    }
</script>
