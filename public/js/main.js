(function ($) {
    // ヘッダー画像スライド
    const images = $('#slide img');
    let counter = 0;
    let index = 0;

    function slide() {
        setInterval(function () {
            images.eq(index).css('display', 'none');

            index = ++counter % images.length;

            images.eq(index).fadeIn();
        }, 5000);
    }
    slide();

    // 条件絞り込み検索表示非表示
    $("#key-word").on("click", function () {
        //チェックボックスのチェックを外す
        $('.checkbox').each(function (i, e) {
            if (e.checked) {
                e.checked = false;
            }
        })
        $(".popup")
            .addClass("show")
            .fadeIn();
    });

    $("#close").on("click", function () {
        $(".popup").fadeOut();
    });
    // フリーワード検索表示非表示
    $("#free-word").on("click", function () {
        $(".freeWordPopup")
            .addClass("show")
            .fadeIn();
    });
    $("#freeWordPopupClose").on("click", function () {
        $(".freeWordPopup").fadeOut();
    });



    // ルーレットポップアップ表示非表示
    $("#roulette").on("click", function () {
        // ルーレットボタンリストが5件以下の場合非表示
        var array = new Array();
        $(".viewdata-img").each(function (i, e) {
        array[i] = i;
        })
        if (array.length < 5) {
            alert('リストルーレットはリストが5件以上の時に利用できます。')
        } else {
            $(".roulettepopup")
            .addClass("show")
                .fadeIn();
            // コンテンツの数だけ枠を表示
            var viewdataNumner = array.length;
            //コンテンツの数に応じてレイアウト調整（枠）
            if (viewdataNumner == 6 || viewdataNumner == 7 || viewdataNumner == 8) {
                $(".top-banner").addClass(`top-banner-${viewdataNumner}`);
            }
            let arr = []
            for (i = viewdataNumner; i < 10; i++){
                arr.push(i);
            }
            var date = $(".top-banner li")
            date.each(function (i, e) {
                if (arr.includes(i)) {
                    $(`#${i}`).hide();
                }
            })
        //前のデータがあれば削除
        if ($(".target").length) {
            $(".target").each(function (i, e) {
                e.remove();
            });
        }
        //ストップボタンを隠す
        $("#stop").hide();
        //ルーレット対象のお店の名前を取得
        $(".restName").each(function (i, e) {
            //お店の名前を省略
            // 10文字以下の場合
            var textContent = e.innerText;
            var text = textContent.slice(0, 12);
            var text = text + "..";
            $(`#p-${i}`)
                .text(text)
                .attr({
                    class: "roulette-p"
                });
        });
        //ルーレットの画面遷移先URLを取得
        $('.buttonArea > a').each(function (i, e) {
            var href = $(this).attr('href');
            $(`#a-${i}`).attr({
                href: `${href}`
            });
        })
        //ルーレット対象のimgデータを取得
        $(".viewdata-img").each(function (i, e) {
            var className = e.className
            if (className.match('noimage')) {
                $("<img>")
                    .attr({
                        src: "../images/noimage.png",
                        class: "target",
                        id: `src-${i}`
                    })
                    .insertAfter(`#p-${i}`);
            } else {
                $("<img>")
                    .attr({
                        src: `${e.src}`,
                        class: "target",
                        id: `src-${i}`
                    })
                    .insertAfter(`#p-${i}`);
            }
        });
        }
    });

    var a = null;
    // ルーレットスタート
    function start() {
        a = 'ON';
        //コンテンツがあるデータ数を取得
        var array = new Array();
        $(".viewdata-img").each(function (i, e) {
        array[i] = i;
        })
        // コンテンツ数保持
        var viewdataNumber = array.length
        Timer = setInterval(function () {
            if ($(".targetBorder").length) {
                var id = $(".targetBorder").attr("id");
                $(`#${id}`).removeClass("targetBorder");
            }
            var n = Math.floor(Math.random() * viewdataNumber);
            $(`#${n}`).addClass("targetBorder");
        }, 30);
    }
    //ストップボタン押下時
    function stop() {
        a = null;
        clearInterval(Timer);
    }
    // スタートボタン押下時
    $("#start").on("click", function () {
        start();
        $("#start").hide();
        $("#stop").show();
    });
    $("#stop").on("click", function () {
        stop();
        $('#start').show();
        $('#stop').hide();
    });
    //閉じるボタン押下時
    $("#rouletteclose").on("click", function () {
        if (a == 'ON') {
            clearInterval(Timer);
        }
        //スタートボタン表示
        $('#start').show();
        $(".roulettepopup").fadeOut();
    });

    // フリーワード検索
    $("#freeWordForm").submit(function () {
        // フリーワードを取得
        var freeWordText = $("#freeWordText").val();
        if (!freeWordText) {
            $("#freeWordText").focus();
            return false;
        } else {
            // フリーワードを分割して配列を生成
            var freeWordTextList = freeWordText.split("、", 3);
            console.log(freeWordTextList);
            $("#freeWordText").val(freeWordTextList);
        }
    });
    //現在地から検索
    $("#location-information").on("click", function () {
        if (navigator.geolocation) {
            // Geolocation APIに対応している
            alert("このアプリでは位置情報を取得します");
        } else {
            // Geolocation APIに対応していない
            alert("位置情報を有効化してください");
        }
        $(function () {
            // 現在地を取得
            // $("#situation").text("位置情報を検索中です..");
            //検索ボタンの無効化
            $("#location-information").prop("disabled", true);
            $("#key-word").prop("disabled", true);
            $("#roulette").prop("disabled", true);
            $("#free-word").prop("disabled", true);

            navigator.geolocation.getCurrentPosition(
                // 成功
                function (position) {
                    // パラメータセット
                    $("#latitude").val(position.coords.latitude); //経度
                    $("#longitude").val(position.coords.longitude); //緯度
                    //データ送信
                    $("#locationinfomationform").submit();
                    // ログ
                    console.log("経度:" + latitude);
                    console.log("緯度:" + longitude);
                    console.log("送信");
                    //検索ボタンの無効化
                    $("#location-information").prop("disabled", false);
                    $("#free-word").prop("disabled", false);
                    $("#key-word").prop("disabled", false);
                    $("#roulette").prop("disabled", false);
                },
                // 失敗
                function (error) {
                    $("#location-information").prop("disabled", false);
                    $("#free-word").prop("disabled", false);
                    $("#key-word").prop("disabled", false);
                    $("#roulette").prop("disabled", false);
                    switch (error.code) {
                        case 1: //PERMISSION_DENIED
                            alert("位置情報の利用が許可されていません");
                            break;
                        case 2: //POSITION_UNAVAILABLE
                            alert("現在位置が取得できませんでした");
                            break;
                        case 3: //TIMEOUT
                            alert("タイムアウトになりました");
                            break;
                        default:
                            alert(
                                "その他のエラー(エラーコード:" +
                                error.code +
                                ")"
                            );
                            break;
                    }
                }
            );

            return false;
        });
    });
})(jQuery);
