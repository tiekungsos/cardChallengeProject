<template>
    <div class="container">
        <div class="row justify-content-center">
    
            <div class="col-md-2">
                <div class="card">
                   <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <h5 class="card-title">Click</h5>
                            <p class="card-text">{{click}}</p>
                        </li>
                        <li class="list-group-item">
                            
                            <h5 class="card-title">My Best</h5>
                            <p class="card-text">{{mybest}}</p>
                        </li>
                        <li class="list-group-item">
                            <h5 class="card-title">Global Best</h5>
                            <p class="card-text">{{globalmybest}}</p>
                        </li>
                    </ul>
                </div>

                <button type="button" class="btn btn-secondary button-new-game" @click="newGame()" >New Game</button>
            </div>
            <div class="col-md-10">
                <div class="row">
                    <div class="col-3" style="margin-bottom: 30px;" v-for="(item, index) in numbersRand" :key="index">
                        <flipper class="cover-cart card-select Card-filber"
                            width="100%"
                            height="9.9vw"
                            :flipped="item.result"
                            duration='0.3s'
                            @click="onClick(index)">
                            
                            <div slot="front" class="front-card"> 
                                <h1 v-if="item.result" >{{ item.genkey }}</h1>
                                <h1 v-else >{{ item.id }}</h1>
                            </div>

                            <div slot="back" class="back-card">?</div>
                        </flipper>

                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data () {
            return {
                numbers: [ 1, 2, 3, 4, 5, 1, 2, 3, 4, 5, 6, 6 ],
                numbersRand: [],
                numbersSave: [],
                cardOpen: [],
                cartMatch : [],
                mybest : 0,
                globalmybest : 0,
                cardOpenCount: 0,
                click : 0
            }
        },
        mounted() {
            this.buildData()
            this.getData()
        },
        methods: {
            async newGame () {
                this.cardOpen = []
                this.click = 0
                this.cardOpenCount = 0
                this.cartMatch = []
                await this.resetCardOpen();
                await this.sleep(1000);
                this.buildData()
            
            },
            onClick (key) {
             
                if(!this.numbersRand[key].result || this.cardOpenCount > 2) {
                    return
                }

                this.click++
                this.cardOpen.push(this.numbersRand[key]);
                this.cardOpenCount++
              
                this.numbersRand[key].genkey = this.numbersRand[key].id ;
                this.numbersRand[key].result = !this.numbersRand[key].result;

                //check card match
                this.checkCardMatch()

                //if open complete all card
                if(this.cartMatch.length == this.numbersRand.length) {
                    this.saveData();
                }

                if(this.cardOpenCount >= 2 ) {
                    // console.log(this.cartMatch);
                    this.resetCardOpen() //reset card open
                    this.cardOpenCount = 0;
                    this.cardOpen = []
                    return;
                }
            },
            async resetCardOpen () {
                    await this.sleep(500);
                this.numbersRand = this.numbersRand.map((data, index) => {
                    var cardOpen = this.cartMatch.filter(element => {
                        if(element.key == data.key) {
                            return true;
                        }
                    });

                    if(cardOpen.length !== 0) {
                        return {id : data.id, result: false, key : data.key, genkey : data.genkey}
                    }
                
                    return {id : data.id, result: true, key : data.key, genkey : data.genkey}
                })

            
            },
            checkCardMatch () {
              
                if(this.cardOpenCount == 2 && (this.cardOpen[0].id == this.cardOpen[1].id)){
                    this.cardOpen.forEach(element => {
                        this.cartMatch.push(element);
                    });
                }

                return false;
            },
            buildData () {
                 var ctr = this.numbers.length, temp, index;

                // if (!this.numbersRand.length) {
                //     return this.numbersRand;
                // }

                 this.numbersSave = this.numbers.map((number, index) => {
                    return {id : number, result: true, key : index, genkey : this.makeid()}
                })

                // While there are elements in the array
                while (ctr > 0) {
                    // Pick a random index
                    index = Math.floor(Math.random() * ctr);
                    // Decrease ctr by 1
                    ctr--;
                    // And swap the last element with it
                    temp = this.numbersSave[ctr];
                    this.numbersSave[ctr] = this.numbersSave[index];

                
                    this.numbersSave[index] = temp;
                }

                this.numbersRand = this.numbersSave;
            },
            sleep(ms) {
                    return new Promise((resolve) => {
                    setTimeout(resolve, ms);
                });
            },
            getData() {
                this.$http({
                    url: 'auth/score',
                    method: 'GET'
                })
                .then((res) => {

                    if(res.status === 200) {
                          var data = res.data
                          this.mybest = data.data ? data.data.score : 0
                          this.globalmybest = data.bestScore ? data.bestScore.score : 0
                    }
                   
                }, (res) => {
                    this.has_error = true
                })
            },
            saveData() {
                 this.$http({
                    url: 'auth/scoreSave',
                    method: 'post',
                     data: {
                        score: this.click
                    },
                })
                .then((res) => {

                    if(res.status === 200) {
                        this.getData()
                      console.log(res.data.message);
                    }
                   

                  console.log(res);
                  
                }, (res) => {
                    console.log(res);
                    this.has_error = true
                })
            },
            makeid() {
                 var result           = '';
                var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
                var charactersLength = characters.length;
                for ( var i = 0; i < 10; i++ ) {
                    result += characters.charAt(Math.floor(Math.random() * charactersLength));
                }
                return result;
            }
        }
    }
</script>
