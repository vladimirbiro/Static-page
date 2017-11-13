# Static-page

## Install

**Neon:**

services:
    - VladimirBiro\StPage\StaticPageManager
    -
        implement: VladimirBiro\StPage\IStaticPageControlFactory
        inject: yes


**Presenter:**

/** @var VladimirBiro\StPage\IStaticPageControlFactory @inject */
public $staticPageControlFactory;

// ... Newsletter
protected function createComponentStaticPageForm()
{
    return $this->staticPageControlFactory->create();
}


**Template:**

{control staticPageForm}