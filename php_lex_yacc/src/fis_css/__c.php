<?php $context = array(); $context["a"] = 1; echo $context["a"] . "\n";$context["c_b"] = 123; echo $context["c_b"] . "\n";echo $context["c_b"];$context["ok"] = "yes!!"; echo $context["ok"] . "\n";$context["no"] = "no!!\\\""; echo $context["no"] . "\n";$context["mixin"]["@abc"] = "color: #345;\r\n";if((bool)(($context["a"]) == (1))){echo $context["ok"];if((bool)(($context["c_b"]) == (123))){echo $context["ok"];}}else{echo $context["no"];}echo $context["mixin"]["@abc"];; ?>