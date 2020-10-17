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
        <p>平均予算:</p>
        <!-- <h6>情報更新日時:{{ rest.update_date }}</h6> -->
        <!-- 使用端末により対応するurlを付与 -->
        <div class="buttonArea">
          <a v-if="usedTerminal == 1" v-bind:href="rest.url">
            <button type="button" class="btn view-btn">ぐるなび</button>
          </a>
          <a v-if="usedTerminal == 2" v-bind:href="rest.url_mobile">
            <button type="button" class="btn view-btn">ぐるなび</button>
          </a>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    viewData: {
      type: Array,
    },
    usedTerminal: {
      type: Number,
    },
  },
  data() {
    return {
      name: "name",
      shop_image1: "favicon.ico",
      pr_short: "pr_short",
      lunch: "lunch",
      address: "address",
      tel: "tel",
      url: "localhost",
    };
  },
  mounted() {
    // this.getrest();
    console.log("mounted");
  },
  methods: {
    //   axios.get("/getrest").then((res) => {
    //     this.rest = res.viewData;
    //   });
    // },
  },
  name: "main-page",
};
</script>
<style scoped>
/* お店カード */
.row {
  /* margin-bottom: 20px; */
  height: auto;
  border-radius: 4px;
  /* background-color: #444; */
  color: #444;
}
.viewdata {
  min-height: 250px;
  background: cornsilk;
  border-bottom:2px solid bisque;
  /* color: whitesmoke !important; */
  /* box-shadow: whitesmoke 1px 1px 5px; */
}

.imageArea {
  width: 30%;
}

.contentArea {
  width: 70%;
}
.view-btn {
  width: 120px !important;
  /* border: 2px solid #000; */
  border-radius: 3px;
  background: sandybrown;
  color: whitesmoke !important;
}
.view-btn:hover {
    opacity: 0.8;
}
.restName {
  margin-top: 5px;
  margin-left: 5px;
  background: bisque;
  padding: 5px;
  border-bottom: 3px solid sandybrown;
  width: fit-content;
  box-shadow: 2px 2px 2px burlywood;
  border-radius: 4px;
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
</style>
