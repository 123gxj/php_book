<!-- 下拉导航菜单 -->
<nav id="nav" class="nav home">
<h3><a href="https://www.17sucai.com/">><?php echo $configlist[0]['value']  ?></a></h3>	
    <div id="scrollerBox" class="scrollerBox">
        <div class="scroller">
            <ul>
                <?php foreach($catelist as $item){?>
                <li><a href="booklist.php?cateid=<?php echo $item['id'];?>"><?php echo $item['name'];?></a></li>
                <?php }?>
            </ul>
        </div>
    </div>
</nav>
<!-- 下拉导航菜单END -->