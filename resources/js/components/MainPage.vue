<template>
  <div>
    <div class="row viewdata" v-for="rest in viewData" v-bind:key="rest.id">
      <div class="imageArea">
        <div v-if="!rest.image_url.shop_image1" class="viewdata-img noimage"></div>
        <img
          v-else
          class="viewdata-img"
          v-bind:src="rest.image_url.shop_image1"
          v-bind:alt="rest.name"
        />
      </div>
      <div class="contentArea">
        <h5 class="restName">
          {{ rest.name }}
          <span>{{ rest.category }}</span>
        </h5>
        <p>住所:{{ rest.address }}</p>
        <p>
          電話番号:
          <a v-bind:href="`tel:${rest.tel}`">{{ rest.tel }}</a>
        </p>
        <p class="pr-p">PR:{{ rest.pr.pr_short }}</p>
        <p>平均予算:{{ rest.budget }}</p>
        <div class="buttonArea">
          <a v-if="usedTerminal == 1" v-bind:href="rest.url">
            <button type="button" class="btn view-btn">詳細</button>
          </a>
          <a v-if="usedTerminal == 2" v-bind:href="rest.url_mobile">
            <button type="button" class="btn view-btn">詳細</button>
          </a>
          <a v-if="userData.status == 1" >
            <button @click="favo(rest.id)" type="button" class="btn view-btn" v-bind:id="rest.id">お気に入り</button>
          </a>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
const axios = require('axios');
export default {
  props: {
    viewData: {
      type: Array,
    },
    usedTerminal: {
      type: Number,
    },
    userData: {
      type: Array,
    },
  },
  data() {
    return {
        favomessage:'',
    };
  },
  mounted() {
    console.log("mounted");
    var self = this;
  },
  methods: {
    //   お気に入り処理
      favo:  async function(restId){
        NProgress.start();
        var data = {
            restId: restId
        }
        await axios.post('https://nanitaberu.uh-oh.jp/favo',data)
        .then(res => {
            NProgress.done();
            data = null;
            //既にお気に入り済の場合
            if(res.data.flg == 1){
                alert(res.data.message);
            }else if(res.data.flg == 40){
                alert(res.data.message);
            }else{
                //新規お気に入りの場合
                console.log(res);
                self.favomessage = res.data.name;
                alert(self.favomessage + 'をお気に入りに登録しました。');
            }
        })
        .catch(error => {
            NProgress.done();
            // this.endProcessing()
            console.log('error');
            console.log(error);
        })
        console.log(restId);
      }
  },
  name: "main-page",
};
</script>
<style scoped>
/* お店カード */
.row {
  height: auto;
  color: #444;
}
.viewdata {
  min-height: 250px;
  background: white;
  padding: 20px;
  margin: 20px;
  border-radius: unset !important;
}
.viewdata:hover {
    box-shadow: 1px 1px 10px black;
}

.imageArea {
  width: 30%;
}

.contentArea {
  width: 70%;
}
.view-btn {
  width: 120px !important;
  background: whitesmoke;
  border: 1px solid gainsboro;
  border-radius: unset;
}
.view-btn:hover {
    opacity: 1.0;
    border: 1px solid gray;
}
.favo-btn {
    background: burlywood;
    color: whitesmoke;
}
.restName {
  margin-top: 5px;
  margin-left: 5px;
  padding: 5px;
  width: fit-content;
  font-weight: bold;
}
.contentArea p {
  margin-left: 10px;
}
.buttonArea {
  width: 100%;
  text-align: end;
}
.pr-p {
  min-height: 46px;
}
.noimage {
  background-image: url("../assets/img/noimage.png");
  height: 265px;
  background-position: center;
}
@media screen and (max-width: 450px) {
    .view-btn {
        width: 80px !important;
    }
}
</style>
