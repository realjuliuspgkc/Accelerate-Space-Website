<?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/head.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . '/db.php');

    $post = $_GET['post'] ?? 'updates';

    $stmt = $conn->prepare("SELECT * FROM update_posts WHERE redirect = ?");
    $stmt->bind_param("s", $post);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $publisher = $row['publisher'];
            $title = $row['title'];
            $contents = $row['contents'];
            $image = $row['image'];
            $createdAt = $row['created_at'];
        }
    }
?>

<title><?php echo $title;?> </title>

<section class="blog_header">
<div class="blog_header-container container">
    <div class="crumbs">
        <a class="crumb" href="/updates/"><svg xmlns="http://www.w3.org/2000/svg" width="8.2" height="15.7" class="svg-chevron-left"><path d="M7.5 15.7L0 7.8 7.5 0l.7.7-6.8 7.1L8.2 15z"></path></svg>
        Back</a>
    </div>
    <div class="blog_header-content">
        <h1 class="blog_header-post-title"><?= htmlspecialchars($title)?></h1>
        <p class="blog_header-post-title" style="font-size: 15px; letter-spacing: normal;">Published by <?= htmlspecialchars($publisher)?></h1>
        <p class="blog_header-post-title" style="font-size: 15px; letter-spacing: normal;">Published at <?= htmlspecialchars($createdAt)?></h1>
    </div>
</div>
</section>

<section class="blog_info">
<div class="container">
    <div class="blog_info-content">

        <div class="blog_info-featured">
            <img src=<?= htmlspecialchars($image)?> alt=<?= htmlspecialchars($title)?>/>
        </div>


        <p><?php echo nl2br($contents); ?></p>
</section>