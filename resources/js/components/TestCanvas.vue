/* eslint-disable no-unused-vars */
<template>

    <div id="canvasTest">
       
        <div id="viewtactic">
            <h2>Tactic name is {{ tacticName }}</h2>
            
        </div>
        <div class="buttonDiv">
            <div class="Buttons">
                <button class="button" @click="addHomePlayer(); coun=1">Add HOME player!</button>
                <button class="button" @click="removeHomePlayer(); coun=1">Remove HOME player!</button>
            </div>

            <div class="Buttons">
                <label class="switch">
                    <input type="checkbox" id="checkbox" @click="checkBoxAddRemoveBall();">
                    
                    <span class="slider round"></span>
                </label>
            </div>

            <div class="Buttons">
                <button class="button" @click="addAwayPlayer();">Add AWAY player!</button>
                <button class="button" @click="removeAwayPlayer();">Remove AWAY player!</button>
            </div>
            <div class= "saveStartCords">
                <button class="button">Save start coordinates</button>
            </div>
           
        </div>
    
        <div class="fieldAndInputs">
            <div class="field">
                <div class= "courtKonvas">
                <table class="Court" style="overflow-x:auto;" >
                <tr>
                <td>
                <v-stage class="stage"
                    ref="stage"
                    :config="configKonva"
                    @dragstart="handleDragstart"
                    @dragend="handleDragend"
                    

                >
                    <v-layer ref="layer">
                        <v-image :config="{
                            width: configKonva.width,
                            height: configKonva.height,
                            image: img,
                            listening: false,
                            fillEnabled: true,
                        }"/>

                        
                       

                        <!-- <v-circle
                            v-for="item in ball"
                            :key="item.id"
                            :config="{
                                x: item.x,
                                y: item.y,
                                rotation: item.rotation,
                                id: item.id,
                                radius: 15,
                                fill: 'black',
                                opacity: 0.8,
                                draggable: true,
                                scaleX: dragItemAwayId === item.id ? item.scale * 1.2 : item.scale,
                                scaleY: dragItemAwayId === item.id ? item.scale * 1.2 : item.scale,
                                shadowColor: 'black',
                                shadowBlur: 10,
                                shadowOffsetX: dragItemAwayId === item.id ? 15 : 5,
                                shadowOffsetY: dragItemAwayId === item.id ? 15 : 5,
                                shadowOpacity: 0.6,
                                prevCords: item.preCords,
                                dragBoundFunc: function (pos){
                                    y1 =  pos.y < 20 ? 20 :pos.y && pos.y > 480 ? 480 :pos.y;
                                    x1 = pos.x < 20 ? 20 :pos.x && pos.x >980 ? 980 :pos.x;
                                    return{
                                        x: x1,
                                        y: y1,
                                    };
                                },
                            }"
                            
                        ></v-circle> -->
                    </v-layer>
                </v-stage>
                </td>
                </tr>
                </table>
            </div>
            </div>
            <div class="inputs">
                <table class="actionTimeTable" style="overflow-x:auto;">
                    <tr>
                        <th></th>
                        <th>Action time</th>
                        <th>Save</th>
                    </tr>
                    <tr>
                        <td class= "IdCell">Action time</td>
                        <td class= "inputCell">
                            <input type="text" class="inputField" placeholder="action time (secs)" v-model="userInput.animDuration">
                        </td>
                        <td class= "saveButton"><button class="button">Save</button></td>
                    </tr>
                </table>
            </div>
           
        </div>
       
        <button @click="replayAnim">Replay animation</button><br>
        <button @click="circleWork">Test!</button>
        <button @click="setCords">Lock coordinates!</button>
        
        
    </div>
</template>

<script>
    
    import Konva from "konva";
    import SampleRequest from '@/api/sample-request';
    const sampleRequest = new SampleRequest();
    export default {
        
        name: 'TestCanvas',
        created() {
            this.getData();
        },
        data() {
            return {
                sports: {},
                coun: 0,
                sportsName: null,
                image: null,
                xpoint: 0,
                ypoint: 0,
                x1: 0,
                y1: 0,
                counter: 0,
                id_preset: 56,
                canvas: null,
                context: null,
                img: null,
                drawIt: false,
                coords: [],

                tactics: {},
                id: this.$route.params.id,
                tacticName: null,
                presetID: null,
                ser : null,
                //atskirigs
                // coords: [],
                listHome: [], //home speletaju info
                listAway: [], //away speletaju info
                listBall: [], //speles bumba info
                dragItemAwayId: null,
                dragItemHomeId: null,
                dragItemBallId:null,
                delItemHomeId: null,
                delItemAwayId: null,
                delItemBallId: null,
                setItemCords: null,
                configKonva: {
                    width: 1000,
                    height: 500,
                    
                },
                homeCount : 0,//home bumbinu skaits uz laukuma (info)
                awayCount: 0,// enemy bumbinu skaits uz laukuma (info)
                ballCount:0, //bumba uz laukuma (info)
                homeCount1 : 0, //skaita home bumbu skaitu uz laukuma
                awayCount1 : 0,  //skaita away bumbu skaitu uz laukumu
                ballCount1:0, //bumba uz laukuma skaits
                ballEnabled: null, //lai bumbu varetu izslegt bez pavilksanas

                changeHomeX : 70,
                changeY: 30,
                changeAwayX: 650,
                changeBallX: 500,
                iter: null,
                lock: [],
                setUp: 0,
                choiceId: null,
                choiceIdAway: null,
                isPlaying: false,
                
                // homeTableData:[], //dinamiskas tabulas dati par animacijas laiku un id
                // awayTableData:[],
                // homeFieldCounter: 0, //skaita home ievades laukus. velak bus janem nost
                // awayFieldCounter:0,

                circle: null,
                cnt: 0,
                listHomePlayers: [],// lista liekas home speletaju apli
                listAwayPlayers: [], //lista liekas away speletaju apli
                listBall2: [], //lista liekas bumbas aplis
                identy: null,
                tweensHome: [],
                tweensAway:[],
                count_times: 0,
                handledPlayersHome: [],
                handledPlayersAway: [],
                handledBall: [],
                userInput: {
                    animDuration: null,
                },
            }
        },
        mounted(){//starts up with loading of the page
            // console.log("Izsaucas mounted");
            // this.canvas = document.getElementById("canv");
            // this.context = this.canvas.getContext('2d');
            // for (let n = 0; n < 5; n++) {
            //     this.list.push({
            //         id: Math.round(Math.random() * 10000).toString(),
            //         x: Math.random() * 1000,
            //         y: Math.random() * 500,
            //         rotation: Math.random() * 180,
            //         scale: 1
            //     });
            // }
        },
       
       
        methods: { 
            // SITA METODE IES EDITTACTIC LAI IELADETU BILDi
            // async getData(){ 
            // console.log("Editing:",this.id);
            //     const {data} = await sampleRequest.getTacticName({id:this.id});
            //     this.tactics = data;
            //     this.tacticName = data.tactic_name;
            //     console.log('Data:', data);
            //     this.presetID = data.id_presets;
            //     this.userID = data.id_user;
            //     this.image=data.sports_type.field_picture;
                
                
            //     console.log('Data:', data.tactics_name);
            //     this.img = new window.Image();
            //     this.img.src = this.image;
            //     this.img.onload = () => {
            //         // set image only when it is loaded
            //     };
            // },


            async getData(){
                const {data} = await sampleRequest.getSportsTypes({ id:this.id_preset});
                this.sportsName = data.sports_name;
                this.sports = data;
                this.image = data.field_picture;
                console.log('Data:', data.sports_name);
                this.img = new window.Image();
                this.img.src = this.image;
                this.img.onload = () => {
                    // set image only when it is loaded
                };
            },

      
            
            handleDragstart(e){//drag handler for inbuilt js circle creation
                this.choiceId = e.target.id();
                if(this.choiceId.includes('Home_')){
                    this.shoutout("The chosen one is: ", this.choiceId);
                    this.dragItemHomeId = e.target.id();
                    this.shoutout("dragItemHomeId", this.dragItemHomeId);
                    const item = this.listHome.find(i => i.id === this.dragItemHomeId);
                    const circle = this.listHomePlayers.find(i => i.id === this.dragItemHomeId);
                    const index = this.listHome.indexOf(item);
                    const index2 = this.listHomePlayers.indexOf(circle);
                    this.shoutout("Circle cord test: ", circle.circ.x());
                    this.x1 = item.x;
                    this.y1 = item.y;
                    this.shoutout(this.x1,this.y1);
                    // item.preCords.push({x: this.x1,y:this.y1});
                    this.listHome.splice(index, 1);
                    this.listHome.push(item);
                    this.listHomePlayers.splice(index2, 1);
                    this.listHomePlayers.push(circle);
                }
                else if(this.choiceId.includes('Away_')){
                    this.shoutout("The chosen one is: ", this.choiceId);
                    this.dragItemAwayId = e.target.id();
                    this.shoutout("dragItemAwayId", this.dragItemAwayId);
                    const item = this.listAway.find(i => i.id === this.dragItemAwayId);
                    const circle = this.listAwayPlayers.find(i => i.id === this.dragItemAwayId);
                    const index = this.listAway.indexOf(item);
                    const index2 = this.listAwayPlayers.indexOf(circle);
                    this.shoutout("Circle cord test: ", circle.circ.x());
                    this.x1 = item.x;
                    this.y1 = item.y;
                    this.shoutout(this.x1,this.y1);
                    // item.preCords.push({x: this.x1,y:this.y1});
                    this.listAway.splice(index, 1);
                    this.listAway.push(item);
                    this.listAwayPlayers.splice(index2, 1);
                    this.listAwayPlayers.push(circle);
                }else{
                    this.shoutout("The chosen one is: ", this.choiceId);
                    this.dragItemBallId = e.target.id();
                    this.shoutout("dragItemBallId", this.dragItemBallId);
                    const item = this.listBall.find(i => i.id === this.dragItemBallId);
                    const circle = this.listBall2.find(i => i.id === this.dragItemBallId);
                    const index = this.listBall.indexOf(item);
                    const index2 = this.listBall2.indexOf(circle);
                    this.shoutout("Circle cord test: ", circle.circ.x());
                    this.x1 = item.x;
                    this.y1 = item.y;
                    this.shoutout(this.x1,this.y1);
                    // item.preCords.push({x: this.x1,y:this.y1});
                    this.listBall.splice(index, 1);
                    this.listBall.push(item);
                    this.listBall2.splice(index2, 1);
                    this.listBall2.push(circle);
                }
            },

            handleDragend(e){//drag end handler for inbuilt js circle creation
                this.choiceId = e.target.id();
                if(this.choiceId.includes('Home_')){
                    this.dragItemHomeId = e.target.id();
                    this.delItemHomeId = this.dragItemHomeId;
                    if(this.handledPlayersHome.indexOf(this.delItemHomeId) < 0){//adds moved players to the list
                        console.log("It was not in the array!");
                        this.handledPlayersHome.push(this.delItemHomeId);
                    }
                    this.shoutout("delItemHomeId: ", this.delItemHomeId);
                    const item = this.listHome.find(i => i.id === this.dragItemHomeId);

                    item.x = e.target.x();
                    item.y = e.target.y();
                    this.shoutout("Old coordinates for: ",item.id," is: ",item.preCords);
                    this.shoutout("New coordinates for: ",item.id," is: ",item.x,item.y);
                    this.dragItemHomeId = null;
                }
                else if(this.choiceId.includes('Away_')){
                    this.dragItemAwayId = e.target.id();
                    this.delItemAwayId = this.dragItemAwayId;
                    if(this.handledPlayersAway.indexOf(this.delItemAwayId) < 0){//adds moved players to the list
                        console.log("It was not in the array!");
                        this.handledPlayersAway.push(this.delItemAwayId);
                    }
                    this.shoutout("delItemAwayId: ", this.delItemAwayId);
                    const item = this.listAway.find(i => i.id === this.dragItemAwayId);
                    item.x = e.target.x();
                    item.y = e.target.y();
                    this.shoutout("Old coordinates for: ",item.id," is: ",item.preCords);
                    this.shoutout("New coordinates for: ",item.id," is: ",item.x,item.y);
                    this.dragItemAwayId = null;
                }
                else{
                    this.dragItemBallId = e.target.id();
                    this.delItemBallId = this.dragItemBallId;
                    
                    this.shoutout("delItemBallId: ", this.delItemBallId);
                    const item = this.listBall.find(i => i.id === this.dragItemBallId);
                    item.x = e.target.x();
                    item.y = e.target.y();
                    this.shoutout("Old coordinates for: ",item.id," is: ",item.preCords);
                    this.shoutout("New coordinates for: ",item.id," is: ",item.x,item.y);
                    this.dragItemBallId = null;
                }
            },

            setCords(){//sets coordinates where you place them
                this.choiceId = this.delItemHomeId;
                if(this.choiceId.includes('Home_')){
                    this.shoutout("Cnt: ", this.cnt);
                    const item = this.listHome.find(i => i.id === this.delItemHomeId);
                    const player = this.listHomePlayers.find(i => i.id === this.delItemHomeId);
                    // this.tweensHome
                    item.preCords.push({ x:item.x,y:item.y});
                    this.shoutout("current coords added: ",item.preCords);
                    // const thisvar = {...player, x: 100};//very useful for maybe saving and using circles
                    
                    // player.circ.position({
                    //     x: item.preCords[this.cnt].x,
                    //     y: item.preCords[this.cnt].y,
                    // });
                    // item.x = item.preCords[0].x;
                    // item.y = item.preCords[0].y;
                    this.shoutout(player.circ);
                    // var tween = new Konva.Tween({
                    //     node: player.circ,
                    //     duration: 1,
                    //     x: item.preCords[this.cnt].x,
                    //     y: item.preCords[this.cnt].y,
                    //     onUpdate: () => console.log("props updated"),
                    //     onFinish: function(){
                    //         tween.pause();
                    //     }
                    // });
                    this.shoutout("X and Y of added: ", item.preCords[this.cnt].x, item.preCords[this.cnt].y);
                    // this.tweensHome.push(tween);
                    this.cnt++;
                    this.shoutout("Tweens: ", this.tweensHome);
                }
                // else if(this.choiceIdAway.includes('Away_')){
                //     this.shoutout("Cnt: ", this.cnt);
                //     const item = this.listAway.find(i => i.id === this.delItemAwayId);
                //     const player = this.listAwayPlayers.find(i => i.id === this.delItemAwayId);
                //     // this.tweensHome
                //     item.preCords.push({ x:item.x,y:item.y});
                //     this.shoutout("current coords added: ",item.preCords);
                //     this.shoutout(player.circ);
                //     this.shoutout("X and Y of added: ", item.preCords[this.cnt].x, item.preCords[this.cnt].y);
                //     this.cnt++;
                //     this.shoutout("Tweens: ", this.tweensAway);
                // }
            },


            addHomePlayer(){//adds new player object and circle  to the stage
                this.shoutout("COUNT:", this.homeCount);
                if(this.homeCount == 6){ return; }
                this.changeHomeX += 40;
                this.identy = 'Home_'+this.rndStr(4);
                this.shoutout("I have created: ",this.identy, " with count: ",this.homeCount);
                this.listHome.push({
                    id: this.identy,
                    x: this.changeHomeX,
                    y: this.changeY,
                    preCords: [],
                    scale: 1
                });
                const item = this.listHome.find(i => i.id === this.identy);
                this.shoutout("Item: ", item);
                var circle = new Konva.Circle({
                    x: item.x,
                    y: item.y,
                    id: item.id,
                    radius: 20,
                    fill: '#89b717',
                    opacity: 0.8,
                    draggable: true,
                    scaleX: this.dragItemHomeId === item.id ? item.scale * 1.2 : item.scale,
                    scaleY: this.dragItemHomeId === item.id ? item.scale * 1.2 : item.scale,
                    shadowColor: 'black',
                    shadowBlur: 10,
                    shadowOffsetX: this.dragItemHomeId === item.id ? 15 : 5,
                    shadowOffsetY: this.dragItemHomeId === item.id ? 15 : 5,
                    shadowOpacity: 0.6,
                    prevCords: item.preCords,
                    dragBoundFunc: function (pos){
                        this.y1 =  pos.y < 20 ? 20 :pos.y && pos.y > 480 ? 480 :pos.y;
                        this.x1 = pos.x < 20 ? 20 :pos.x && pos.x >980 ? 980 :pos.x;
                        return{
                            x: this.x1,
                            y: this.y1,
                        };
                    },
                });
                this.$refs.layer.getNode().add(circle);
                this.listHomePlayers.push({ id: this.identy,circ: circle });
                this.shoutout("Circle id: ", circle.id());
                this.shoutout("The circle list: ",this.listHomePlayers);
                this.homeCount++;
                this.homeCount1++;
                if(this.homeCount1 == 6){ this.changeHomeY+=40; this.changeHomeX = 175; this.homeCount1 = 0; }
                this.shoutout("COUNT: ", this.homeCount);
            },


            removeHomePlayer(){//removes circle and 
                // var check = this.count-1;
                // if(check <0){ return; }
                if(this.delItemHomeId != null){
                    const item = this.listHome.find(i => i.id === this.delItemHomeId);
                    this.shoutout("Item: ",item);
                    const circle = this.listHomePlayers.find(i => i.id === this.delItemHomeId);
                    this.shoutout("Circle id that deletes: ", circle.circ.id());
                    this.shoutout("Item id that deletes: ", this.delItemHomeId);
                    const index = this.listHome.indexOf(item);
                    const index2 = this.listHomePlayers.indexOf(circle);
                    this.shoutout("Deleted circle: ", index2);
                    this.shoutout("Deleted item: ",index);
                    circle.circ.remove();
                    this.listHomePlayers.splice(index2, 1);
                    this.listHome.splice(index, 1);
                    this.count--;
                    // this.count3--;
                    this.shoutout("COUNT: ",this.homeCount);
                    if(this.homeCount <= 0){
                        this.homeCount = 0;
                    }
                    this.shoutout("Home List data ", this.listHome);
                    this.shoutout("Home circle data ", this.listHomePlayers)
                    this.delItemHomeId = null;
                }else{
                    return;
                }
            },


            addAwayPlayer(){//adds new player object and circle  to the stage
                this.shoutout("COUNT:", this.awayCount);
                if(this.awayCount == 6){ return; }
                this.changeAwayX += 40;
                this.identy = 'Away_'+this.rndStr(4);
                this.shoutout("I have created: ",this.identy, " with count: ",this.awayCount);
                this.listAway.push({
                    id: this.identy,
                    x: this.changeAwayX,
                    y: this.changeY,
                    preCords: [],
                    scale: 1
                });
                const item = this.listAway.find(i => i.id === this.identy);
                this.shoutout("Item: ", item);
                var circle = new Konva.Circle({
                    x: item.x,
                    y: item.y,
                    id: item.id,
                    radius: 20,
                    fill: '#eb4034',
                    opacity: 0.8,
                    draggable: true,
                    scaleX: this.dragItemAwayId === item.id ? item.scale * 1.2 : item.scale,
                    scaleY: this.dragItemAwayId === item.id ? item.scale * 1.2 : item.scale,
                    shadowColor: 'black',
                    shadowBlur: 10,
                    shadowOffsetX: this.dragItemAwayId === item.id ? 15 : 5,
                    shadowOffsetY: this.dragItemAwayId === item.id ? 15 : 5,
                    shadowOpacity: 0.6,
                    prevCords: item.preCords,
                    dragBoundFunc: function (pos){
                        this.y1 =  pos.y < 20 ? 20 :pos.y && pos.y > 480 ? 480 :pos.y;
                        this.x1 = pos.x < 20 ? 20 :pos.x && pos.x >980 ? 980 :pos.x;
                        return{
                            x: this.x1,
                            y: this.y1,
                        };
                    },
                });
                this.$refs.layer.getNode().add(circle);
                this.listAwayPlayers.push({ id: this.identy,circ: circle });
                this.shoutout("Circle id: ", circle.id());
                this.shoutout("The circle list: ",this.listAwayPlayers);
                this.awayCount++;
                this.awayCount1++;
                if(this.awayCount1 == 6){ this.changeHomeY+=40; this.changeHomeX = 175; this.awayCount1 = 0; }
                this.shoutout("COUNT: ", this.awayCount);
            },

            removeAwayPlayer(){//removes circle and 
                // var check = this.count-1;
                // if(check <0){ return; }
                if(this.delItemAwayId != null){
                    const item = this.listAway.find(i => i.id === this.delItemAwayId);
                    this.shoutout("Item: ",item);
                    const circle = this.listAwayPlayers.find(i => i.id === this.delItemAwayId);
                    this.shoutout("Circle id that deletes: ", circle.circ.id());
                    this.shoutout("Item id that deletes: ", this.delItemAwayId);
                    const index = this.listAway.indexOf(item);
                    const index2 = this.listAwayPlayers.indexOf(circle);
                    this.shoutout("Deleted circle: ", index2);
                    this.shoutout("Deleted item: ",index);
                    circle.circ.remove();
                    this.listAwayPlayers.splice(index2, 1);
                    this.listAway.splice(index, 1);
                    this.awayCount--;
                    // this.count3--;
                    this.shoutout("COUNT: ",this.awayCount);
                    if(this.awayCount <= 0){
                        this.awayCount = 0;
                    }
                    this.shoutout("Away List data ", this.listAway);
                    this.shoutout("Away circle data ", this.listAwayPlayers)
                    this.delItemAwayId = null;
                }else{
                    return;
                }
            },


            
            checkBoxAddRemoveBall(){
                var check = document.getElementById("checkbox");
                if(check.checked == true){
                    this.addBall();
                }
                else{
                    this.removeBall();
                }
            },

            addBall(){//adds new player object and circle  to the stage
                this.shoutout("COUNT:", this.ballCount);
                if(this.ballCount == 1){ return; }
                this.identy = 'Ball_'+this.rndStr(4);
                this.shoutout("I have created: ",this.identy, " with count: ",this.ballCount);
                this.listBall.push({
                    id: this.identy,
                    x: this.changeBallX,
                    y: this.changeY,
                    preCords: [],
                    scale: 1
                });
                const item = this.listBall.find(i => i.id === this.identy);
                this.ballEnabled = this.identy;
                this.shoutout("Item: ", item);
                var circle = new Konva.Circle({
                    x: item.x,
                    y: item.y,
                    id: item.id,
                    radius: 20,
                    fill: '#000000',
                    opacity: 0.8,
                    draggable: true,
                    scaleX: this.dragItemBallId === item.id ? item.scale * 1.2 : item.scale,
                    scaleY: this.dragItemBallId === item.id ? item.scale * 1.2 : item.scale,
                    shadowColor: 'black',
                    shadowBlur: 10,
                    shadowOffsetX: this.dragItemBallId === item.id ? 15 : 5,
                    shadowOffsetY: this.dragItemBallId === item.id ? 15 : 5,
                    shadowOpacity: 0.6,
                    prevCords: item.preCords,
                    dragBoundFunc: function (pos){
                        this.y1 =  pos.y < 20 ? 20 :pos.y && pos.y > 480 ? 480 :pos.y;
                        this.x1 = pos.x < 20 ? 20 :pos.x && pos.x >980 ? 980 :pos.x;
                        return{
                            x: this.x1,
                            y: this.y1,
                        };
                    },
                });
                this.$refs.layer.getNode().add(circle);
                this.listBall2.push({ id: this.identy,circ: circle });
                this.shoutout("Circle id: ", circle.id());
                this.shoutout("The circle list: ",this.listBall2);
                this.ballCount++;
                this.ballCount1++;
                this.shoutout("COUNT: ", this.ballCount);
            },

            removeBall(){//removes circle and 
                // var check = this.count-1;
                // if(check <0){ return; }
                if(this.ballEnabled != null){

                    const item = this.listBall.find(i => i.id === this.ballEnabled);
                    this.shoutout("Item: ",item);
                    const circle = this.listBall2.find(i => i.id === this.ballEnabled);
                    this.shoutout("Circle id that deletes: ", circle.circ.id());
                    this.shoutout("Item id that deletes: ", this.ballEnabled);
                    const index = this.listBall.indexOf(item);
                    const index2 = this.listBall2.indexOf(circle);
                    this.shoutout("Deleted circle: ", index2);
                    this.shoutout("Deleted item: ",index);
                    circle.circ.remove();
                    this.listBall2.splice(index2, 1);
                    this.listBall.splice(index, 1);
                    this.ballCount--;
                    // this.count3--;
                    this.shoutout("COUNT: ",this.ballCount);
                    if(this.ballCount <= 0){
                        this.ballCount = 0;
                    }
                    this.shoutout("Ball List data ", this.listBall);
                    this.shoutout("Ball circle data ", this.listBall2)
                    this.ballEnabled = null;
                }else{
                    return;
                }
            },
            // removeBall(){
            //     var check = this.ballCount-1;
            //     if(check < 0){ return; }
            //     console.log("check: ", this.delItemBallId);
            //     const item = this.ball.find(i => i.id === this.delItemBallId);
            //     this.shoutout("Item: ", item);
            //     const index = this.ball.indexOf(item);
            //     this.shoutout("Deleted: ",index);
            //     this.ball.splice(index, 1);
            //     this.ballCount--;
            //     if(this.ballCount <= 0){
            //         this.ballCount = 0;
            //     }
            //     this.shoutout("Away List data: ", this.ball);
            //     this.delItemBallId = null;
            // },


            replayAnim(){
                let moveHome = this.listHome.find(i => i.id === this.delItemHomeId);
                let moveAway = this.listAway.find(i => i.id === this.delItemAwayId);
                var turnAroun1 = false;
                var turnAroun2 = false;
                this.shoutout(moveHome);
                this.shoutout(moveAway);
                let amplitude = 5;
                var velocity = 50;
                var anim = new Konva.Animation(function (frame) {
                    if(turnAroun1){
                        moveHome.x -= (velocity * (50/ 1000));
                        if(moveHome.x <= 20){
                            turnAroun1 = false;
                        }
                    }else if(moveHome.x >= 980){
                        turnAroun1 = true;
                    }else{
                        moveHome.x += (velocity * (50/ 1000));
                        moveHome.y += amplitude * Math.sin((frame.time * 2 * Math.PI) / 1000);
                    }
                    if(turnAroun2){
                        moveAway.x += (velocity * (50/ 1000));
                        if(moveAway.x >= 980){
                            turnAroun2 = false;
                        }
                    }else if(moveAway.x <= 20){
                        turnAroun2 = true;
                    }else{
                        moveAway.x -= (velocity * (50/1000));
                        moveAway.y += amplitude * Math.sin((frame.time * 2 * Math.PI)/1000);
                    }  
                }, this.$refs.layer.getNode());
                anim.start();
            },
           
            updateCoords(event){
                this.xpoint = event.clientX;
                this.ypoint = event.clientY;
            },
            testingCoords(){
                let stage = this.$refs.stage.getStage();
                var pos = stage.getPointerPosition();
                var x = pos.x;
                var y = pos.y;
                this.xpoint = x;
                this.ypoint = y;
            },

            
            // addHomeItemToTable(){
            //     if(this.homeFieldCounter <=5){
            //         var my_Table = {
            //         id: 'Home_'+this.identy,
            //     };
            //     this.homeTableData.push(my_Table)
            //     this.homeFieldCounter++;
            //     }
            //     else{
            //         return;
            //     }   
            // },

            // addAwayItemToTable(){
            //     if(this.awayFieldCounter <=5){
            //         var my_Table = {
            //         id: 'Away_'+this.identy,
            //     };
            //     this.awayTableData.push(my_Table)
            //     this.awayFieldCounter++;
            //     }
            //     else{
            //         return;
            //     }   
            // },

            // removeHomeItemFromTable(){
            //     var check = this.homeFieldCounter-1;
            //     if(check < 0){ return; }
            //     console.log("check: ", this.delItemHomeId);
            //     const item = this.homeTableData.find(i => i.id === this.delItemHomeId);
            //     this.shoutout("Item: ", item);
            //     const index = this.homeTableData.indexOf(item);
            //     this.shoutout("Deleted: ",index);
            //     this.homeTableData.splice(index, 1);
            //     this.homeFieldCounter--;
            //     if(this.homeFieldCounter <= 0){
            //         this.homeFieldCounter = 0;
            //     }
            //     this.shoutout("Away List data: ", this.homeTableData);
            //     this.delItemHomeId = null;
            // },

            // removeAwayItemFromTable(){
            //     var check = this.awayFieldCounter-1;
            //     if(check < 0){ return; }
            //     console.log("check: ", this.delItemAwayId);
            //     const item = this.awayTableData.find(i => i.id === this.delItemAwayId);
            //     this.shoutout("Item: ", item);
            //     const index = this.awayTableData.indexOf(item);
            //     this.shoutout("Deleted: ",index);
            //     this.awayTableData.splice(index, 1);
            //     this.awayFieldCounter--;
            //     if(this.awayFieldCounter <= 0){
            //         this.awayFieldCounter = 0;
            //     }
            //     this.shoutout("Away List data: ", this.awayTableData);
            //     this.delItemAwayId = null;
            // },

            rndStr(len) {
                let text = "";
                let chars = "abcdefghijklmnopqrstuvwxyz";
                for( let i=0; i < len; i++ ) {
                    text += chars.charAt(Math.floor(Math.random() * chars.length));
                }
                return text;
            },

            circleWork(){
                for (const idplayer of this.handledPlayersHome) {
                    var i = 1;
                    const item = this.listHome.find(i => i.id === idplayer);
                    const player = this.listHomePlayers.find(i => i.id === idplayer);
                    player.circ.position({
                        x: item.preCords[0].x,
                        y: item.preCords[0].y,
                    });
                    this.animPlay(item, player.circ, i);
                }
                return;
            },

            animPlay(item,player,i){
                var tween = new Konva.Tween({
                    node: player,
                    duration: this.userInput.animDuration,
                    x: item.preCords[i].x,
                    y: item.preCords[i].y,
                    onUpdate: () => console.log("first tween updated"),
                    onFinish: () => {
                        console.log("first tween ended");
                        if(item.preCords[i+1]!= null){
                            player.position({
                                x: item.preCords[i].x,
                                y: item.preCords[i].y,
                            });
                            i++;
                            this.animPlay(item,player,i);
                        }
                    },
                });
                tween.play();
            },

        },
    };
</script>

<style lang="scss" scoped>
    #canvasTest{
        
        #viewtactic{
            text-align: center;
        }
        // .stage{
        //     background-color:blue;
        // }
        .layer{
            background-color: rgb(23, 238, 23);
        }

        .stage{
            margin-top:1%;
        }

        .buttonDiv{
            width:100%;
            display:table;
            margin-top:2%;
            text-align: center;
            
        }

        .Buttons{
            display:table-cell;
            float:left;
            margin-left:4%;
        }

        .button{
            margin-top:20%;
            display:inline-block;
            padding:0.3em 1.2em;
            margin:0 0.3em 0.3em 0;
            border-radius:2em;
            box-sizing: border-box;
            text-decoration:none;
            font-family:Arial;
            font-weight:bold;
            color:#FFFFFF;
            background-color:#1db40f;
            text-align:center;
            transition: all 0.2s;
        }

        .button:hover{
            background-color: rgb(25, 136, 30);
            color: white;
            cursor: pointer;
        }

        .switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 34px;
        }           

        .switch input { 
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            -webkit-transition: .4s;
            transition: .4s;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
        }

        input:checked + .slider {
            background-color: #1fc410;
        }

        input:focus + .slider {
            box-shadow: 0 0 1px #1fc410;
        }

        input:checked + .slider:before {
            -webkit-transform: translateX(26px);
            -ms-transform: translateX(26px);
            transform: translateX(26px);
        }

        /* Rounded sliders */
        .slider.round {
            border-radius: 34px;
        }

        .slider.round:before {
            border-radius: 50%;
            }

        .fieldAndInputs{
            display: flex;
            margin-left:3%;
            margin-top:1%;
            //height: 525px;
        }

        .field{
            flex: 1;
            //border: 2px solid rgb(0, 0, 0);
            margin-right: 20px;
        }

        .inputs{
            flex:1;
            border: 2px solid rgb(0, 0, 0);
            float:left;
           //padding-right:1%;
           // margin-right: 2%;
            margin-top:5%;
            overflow-y: auto;
            height: 155px;
            
        }


        .actionTimeTable{
            font-family: Arial;
            border-collapse: collapse;
            width: 100%;
            background-color: #918f8f;
            border-collapse: collapse;
            //border: 1px solid black;
            margin:0 auto;
        }


        table, th, td {
            border: 1px solid black;
            height: 50px;
            // padding-right: 50px;
            //margin-right: 2%;
        }

        table{
            float:left;
        }


        .IdCell{
            width:20%;
            text-align: center;
         }
        
        .inputCell{
            width: 50%;
            text-align: center;
            height: 100px;
        }

        .saveButton{
            width:30%;
            text-align: center;
        }

        .inputField{
            width:70%;
            height: 40px;
            font-size:16px;
            // float:center; //mos vajag
            // margin-right: 5%;
            //margin-left: 25%;
        }
        
        .inputField::placeholder{
            text-align: right;
            margin-right: 10%;
        }

        .saveStartCords{
            float:right;
            margin-right: 7%;
        }



    }
</style>