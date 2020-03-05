<?php

namespace Deployer;

task('artisan:queue:restart', function () {
    run("cd {{release_path}} && command php artisan queue:restart");
});
