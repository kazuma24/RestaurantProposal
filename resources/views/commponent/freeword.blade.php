<div class="freeWordPopup">
    <div class="freeWordContent">
        <form action="
        /freeword" method="post" id="freeWordForm">
            @csrf
            <fieldset>
                <legend>フリーワード</legend>
                <input type="text" name="freeword" id="freeWordText">
                <p>
                    フリーワードは以下の例で検索してください<br>
                    例１：札幌駅、居酒屋、3000円<br>
                    例２：東京駅、焼肉、飲み放題<br>
                    例３：大阪、難波、お好み焼き<br>
                    ※フリーワードは3個まで指定できます<br>
                    またフリワードはは「、」で区切って入力してください<br>
                </p>
                <p style="color: brown;">※フリーワードによっては、検索結果が得られない場合があります</p>
            </fieldset>
            <div class="popupButtonArea">
                <button type="submit" class="btn btn-primary" id="freeWordSearch">検索</button>
                <button type="button" class="btn" id="freeWordPopupClose">閉じる</button>
            </div>
        </form>
    </div>
</div>
