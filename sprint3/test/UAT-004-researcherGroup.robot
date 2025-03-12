*** Settings ***   
Library          SeleniumLibrary
Test Teardown    Close Browser

*** Variables ***
${BROWSER}           chrome
${HOME_URL}          https://cs0404.cpkkuhost.com/researchgroup
${WAIT_TIME}         3s
${WEBDRIVER_PATH}    /Users/ptpspp/Documents/GitHub/git-group-repository-group-4-sec-4/sprint3/test/chromedriver-mac-arm64/chromedriver

# เปลี่ยนภาษา (ตัวเลือกใน dropdown)
${LANG_DROPDOWN_TOGGLE}    xpath=//a[@id="navbarDropdownMenuLink"]
${LANG_TO_THAI}       xpath=//div[contains(@class, 'dropdown-menu')]//a[contains(@href, '/lang/th')]
${LANG_TO_CHINESE}    xpath=//div[contains(@class, 'dropdown-menu')]//a[contains(@href, '/lang/zh')]

# url detail
${URL_DETAIL}    https://cs0404.cpkkuhost.com/researchgroupdetail/3

# ตรวจสอบข้อความที่ต้องปรากฏหลังจากเปลี่ยนภาษา
@{TEXT_TH}    
...    กลุ่มวิจัย
...    เทคโนโลยี GIS ขั้นสูง (AGT)
...    ห้องปฏิบัติการการคำนวณแบบฉลาดขั้นสูง (ASC)
...    หัวหน้าห้องปฏิบัติการ
...    ผศ.ดร. พิพัธน์ เรืองแสง
...    รศ.ดร. ชัยพล กีรติกสิกร

@{TEXT_TH_DETAIL}    
...    หัวหน้าห้องปฏิบัติการ
...    นักศึกษา
...    เพื่อดำเนินการวิจัยและให้บริการวิชาการในสาขาอินเทอร์เน็ต GIS สุขภาพ GIS และแบบจำลองทางอุทกวิทยาด้วย GIS

@{TEXT_ENG}    
...    Research Group
...    Advanced GIS Technology (AGT)
...    Laboratory Supervisor
...    Advanced Intelligent Computing Laboratory (ASC)
...    Asst. Prof. Pipat Reungsang, Ph.D.
...    Assoc. Prof. Chaiyapon Keeratikasikorn, Ph.D.

@{TEXT_ENG_DETAIL}    
...    Laboratory Supervisor 
...    Student
...    To conduct research and provide academic services in the fields of Internet, GIS, Health GIS, and Hydrologic modeling with GIS.

@{TEXT_ZH}    
...    研究小组
...    高级GIS技术（AGT）
...    高级智能计算实验室（ASC）
...    实验室主管
...    助理教授博士 毕发 荣光
...    副教授博士 赛朋 吉凯松

@{TEXT_ZH_DETAIL}    
...    实验室主管
...    学生
...    为了进行研究并提供学术服务，专注于互联网 GIS、健康 GIS 和水文建模 GIS 领域。

*** Keywords ***
Open Browser To Home Page
    Open Browser    ${HOME_URL}    ${BROWSER}    executable_path=${WEBDRIVER_PATH}
    Maximize Browser Window

Change Language To Thai
    Click Element    ${LANG_DROPDOWN_TOGGLE}
    Sleep    2s
    Wait Until Element Is Enabled    ${LANG_TO_THAI}    timeout=10s
    Click Element    ${LANG_TO_THAI}
    ${PAGE_TEXT}    Get Text    xpath=//body
    # ตรวจสอบข้อความภาษาไทย
    FOR    ${TEXT}    IN    @{TEXT_TH}
        Should Contain    ${PAGE_TEXT}    ${TEXT}
    END
    Go To    ${URL_DETAIL}
    ${PAGE_TEXT}    Get Text    xpath=//body
    FOR    ${TEXT}    IN    @{TEXT_TH_DETAIL}
        Should Contain    ${PAGE_TEXT}    ${TEXT}
    END
    Log  "Language changed to Thai successfully."    INFO
    Log To Console  "Language changed to Thai successfully."  # แสดงผลบน Console


Change Language To English
    Click Element    ${LANG_DROPDOWN_TOGGLE}
    Sleep    2s
    ${PAGE_TEXT}    Get Text    xpath=//body
    # ตรวจสอบข้อความภาษาไทย
    FOR    ${TEXT}    IN    @{TEXT_ENG}
        Should Contain    ${PAGE_TEXT}    ${TEXT}
    END
    Go To    ${URL_DETAIL}
    ${PAGE_TEXT}    Get Text    xpath=//body
    FOR    ${TEXT}    IN    @{TEXT_ENG_DETAIL}
        Should Contain    ${PAGE_TEXT}    ${TEXT}
    END
    Log  "Language changed to English successfully."

Change Language To Chinese
    Click Element    ${LANG_DROPDOWN_TOGGLE}
    Sleep    2s
    Wait Until Element Is Enabled    ${LANG_TO_CHINESE}    timeout=10s
    Click Element    ${LANG_TO_CHINESE}
    ${PAGE_TEXT}    Get Text    xpath=//body
    # ตรวจสอบข้อความภาษาไทย
    FOR    ${TEXT}    IN    @{TEXT_ZH}
        Should Contain    ${PAGE_TEXT}    ${TEXT}
    END
    Go To    ${URL_DETAIL}
    ${PAGE_TEXT}    Get Text    xpath=//body
    FOR    ${TEXT}    IN    @{TEXT_ZH_DETAIL}
        Should Contain    ${PAGE_TEXT}    ${TEXT}
    END
    Log  "Language changed to Chinese successfully."

*** Test Cases ***
Admin Login And Change Language To Thai
    Open Browser To Home Page
    Change Language To Thai
    Close Browser

Admin Login And Change Language To English
    Open Browser To Home Page
    Change Language To English
    Close Browser

Admin Login And Change Language To Chinese
    Open Browser To Home Page
    Change Language To Chinese
    Close Browser
