<?php
$image_data = "";
$caption = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['grafica'])) {
    $caption = htmlspecialchars($_POST['caption']);
    if ($_FILES['grafica']['error'] === UPLOAD_ERR_OK) {
        $file_tmp = $_FILES['grafica']['tmp_name'];
        $type = $_FILES['grafica']['type'];
        $data = file_get_contents($file_tmp);
        $image_data = 'data:' . $type . ';base64,' . base64_encode($data);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Instagram Grid & Feed Mockup Tool | High-Fidelity Design Preview</title>
    <meta name="description" content="Professional Instagram UI simulator for designers. Real-time 1:1 grid preview and feed rendering with system-native typography. No data storage.">
    <meta name="keywords" content="Instagram Grid Mockup, IG Feed Preview, Social Media UI Simulator, 1:1 Aspect Ratio Tool, PHP Image Previewer">
    <meta property="og:image" content="https://www.msdvc.it/michelangelo/open.jpg">
<meta property="og:image:type" content="image/jpeg">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">
    <link href="https://fonts.googleapis.com/css2?family=Google+Sans:wght@300;400;500;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --bg: #000000;
            --surface: #111111;
            --brand: #833AB4;
            --brand-glow: rgba(131, 58, 180, 0.3);
            --text-main: #ffffff;
            --text-dim: #777777;
            --glass-border: rgba(255, 255, 255, 0.05);
        }

        body {
            background-color: var(--bg);
            color: var(--text-main);
            font-family: 'Google Sans', sans-serif;
            margin: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 60px 20px;
            animation: bg-pulse 15s infinite alternate;
        }

        @keyframes bg-pulse {
            from { background-color: #000000; }
            to { background-color: #0a0510; }
        }

        .header-section { text-align: center; margin-bottom: 50px; max-width: 750px; }
        h3 { font-weight: 300; letter-spacing: 2px; color: var(--brand); text-transform: uppercase; margin-bottom: 10px; font-size: 0.9rem; }
        
        .upload-card {
            background: var(--surface);
            border: 1px solid var(--glass-border);
            padding: 35px;
            border-radius: 24px;
            width: 100%;
            max-width: 550px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.5);
            margin-bottom: 60px;
        }

        .info-text {
            font-weight: 300;
            font-size: 0.85rem;
            color: var(--text-dim);
            line-height: 1.6;
            margin-bottom: 25px;
            display: block;
        }

        input[type="file"] {
            width: 100%;
            background: #000;
            border: 1px dashed #333;
            padding: 20px;
            color: #555;
            cursor: pointer;
            border-radius: 12px;
            box-sizing: border-box;
        }

        textarea {
            width: 100%;
            background: #000;
            border: 1px solid #222;
            color: #fff;
            padding: 15px;
            font-family: inherit;
            resize: none;
            margin-top: 15px;
            border-radius: 12px;
            box-sizing: border-box;
        }

        button {
            background: var(--brand);
            color: white;
            border: none;
            padding: 18px;
            border-radius: 12px;
            font-weight: 700;
            font-size: 1rem;
            cursor: pointer;
            margin-top: 20px;
            width: 100%;
            box-shadow: 0 10px 20px var(--brand-glow);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        button:hover { transform: translateY(-2px); box-shadow: 0 15px 30px var(--brand-glow); opacity: 0.95; }

        .preview-container {
            display: flex;
            gap: 60px;
            flex-wrap: wrap;
            justify-content: center;
            animation: fadeIn 0.8s ease-out;
            max-width: 1000px;
        }

        @keyframes fadeIn { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }

        .mockup-label {
            font-size: 11px;
            text-transform: uppercase;
            color: var(--brand);
            font-weight: 700;
            margin-bottom: 15px;
            display: block;
            letter-spacing: 1px;
        }

        .mockup-feed { width: 380px; background: #000; border: 1px solid #1a1a1a; box-shadow: 0 10px 30px rgba(0,0,0,0.8); }
        .mockup-grid { width: 300px; }

        .ig-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 2px; background: #1a1a1a; }
        .grid-square { aspect-ratio: 1/1; background: #0a0a0a; overflow: hidden; }
        .grid-square img { width: 100%; height: 100%; object-fit: cover; }

        .user-header { padding: 12px; display: flex; align-items: center; font-weight: 500; font-size: 13px; }
        .avatar { width: 30px; height: 30px; background: linear-gradient(45deg, #f09433, #e6683c, #dc2743, #cc2366, #bc1888); border-radius: 50%; margin-right: 10px; }
        
        .caption-area { padding: 12px; font-size: 13.5px; line-height: 1.5; color: #efefef; }
        .username { font-weight: 700; margin-right: 6px; color: #fff; }

        .reload-btn {
            display: inline-block;
            margin-top: 50px;
            text-decoration: none;
            background: transparent;
            border: 1px solid var(--brand);
            color: var(--brand);
            padding: 12px 30px;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
            transition: all 0.3s ease;
        }

        .reload-btn:hover {
            background: var(--brand);
            color: white;
            box-shadow: 0 5px 15px var(--brand-glow);
        }

        footer { margin-top: 100px; padding: 40px; color: var(--text-dim); font-size: 11px; text-align: center; border-top: 1px solid #111; width: 100%; letter-spacing: 1px; }
    </style>
</head>
<body>

    <div class="header-section">
        <h3>Michelangelo App by <a style="color: #fff; text-decoration: none;" href="https://www.msdvc.it">msdvc</a></h3>
        <small style="color: var(--text-dim); text-transform: uppercase; letter-spacing: 2px;">Professional Design Utility</small>
        <h1 style="font-weight: 700; margin: 10px 0 0 0; font-size: 2.5rem; letter-spacing: -1px;">Instagram UI Post Simulator.</h1>
    </div>

    <div class="upload-card">
        <span class="info-text">
            High-fidelity rendering engine for social media assets. This simulator processes images in local RAM via Base64 encoding to ensure zero data persistence and maximum privacy.
        </span>
        
        <form action="" method="POST" enctype="multipart/form-data">
            <input type="file" name="grafica" accept="image/*" required>
            <textarea name="caption" rows="4" placeholder="Enter post caption metadata..."><?php echo $caption; ?></textarea>
            <button type="submit">EXECUTE UI RENDERING</button>
        </form>
    </div>

    <?php if ($image_data): ?>
    <div class="preview-container">
        <div>
            <span class="mockup-label">Feed Rendering (Native Stack)</span>
            <div class="mockup-feed">
                <div class="user-header">
                    <div class="avatar"></div>
                    preview_user
                </div>
                <img src="<?php echo $image_data; ?>" style="width:100%; display:block;">
                <div class="caption-area">
                    <span class="username">preview_user</span>
                    <?php echo nl2br($caption); ?>
                </div>
            </div>
        </div>

        <div>
            <span class="mockup-label">1:1 Grid Layout Simulation</span>
            <div class="mockup-grid">
                <div class="ig-grid">
                    <div class="grid-square"><img src="<?php echo $image_data; ?>"></div>
                    <div class="grid-square"></div><div class="grid-square"></div>
                    <div class="grid-square"></div><div class="grid-square"></div>
                    <div class="grid-square"></div><div class="grid-square"></div>
                    <div class="grid-square"></div><div class="grid-square"></div>
                </div>
            </div>
        </div>

        <div style="width: 100%; text-align: center;">
            <a href="?" class="reload-btn">NEW SIMULATION / RELOAD</a>
        </div>
    </div>
    <?php endif; ?>

    <footer>
        ENCRYPTED SESSION // NO-LOG POLICY // RAM-ONLY PROCESSING // © 2026 MICHELANGELO APP
    </footer>

</body>
</html>